//
//  RegistrationManager.swift
//  buyTickets
//
//  Created by Alexey Valevich on 06/05/2022.
//

import Foundation
import CryptoKit

protocol CountryLoader {
    func downloadCountries()
    func performRequestCountry(urlS: String)
    func parseJSONCountry(data: Data)
}

protocol PassengerInserter {
    func insertPassenger(firstName: String, lastName: String, login: String, password: String, repeatPassword: String)
    func performRequestPassenger(urlS: String)
    func parseJSONPassenger(data: Data)
}

protocol LoginChecker {
    func performRequestLogin(urlS: String) async throws -> Int
    func parseJSONLogin(data: Data) -> Int
}

class RegistrationManager {
    var countries: [String : Int] = [String : Int]()
    var pickerData = [String]()
    var selectedCountry: Int?
    weak var delegate: RegistrationManagerDelegate?
    
    func setSelectedCountry(to: String) {
        selectedCountry = countries[to]
    }
}

//MARK: - Login checking
extension RegistrationManager: LoginChecker {
    //-1 is the code of an error
    //0 is the code of existing of the login
    //1 is the code of free login
    //-2 is the code for error that have already been shown
    func performRequestLogin(urlS: String) async throws -> Int {
        if let url = URL(string: urlS) {
            do {
                let (data, _) = try await URLSession.shared.data(from: url)
                return self.parseJSONLogin(data: data)
            }
        }
        return -1
    }
    func parseJSONLogin(data: Data) -> Int {
        let decoder = JSONDecoder()
        
        do {
            let decodedData = try decoder.decode(Answer.self, from: data)
            return decodedData.answer! ? 1 : 0
        }catch {
            delegate?.showErrorMessage(message: "Failed to parse data.")
        }
        return -2
    }
}

//MARK: - Passenger insertion
extension RegistrationManager: PassengerInserter {
    func insertPassenger(firstName: String, lastName: String, login: String, password: String, repeatPassword: String) {
        let urlS = K.URLs.verifyLoginURL + "?login=\(login)"
        Task.init {
            var message: String = ""
            if firstName.replacingOccurrences(of: " ", with: "") == "" {
                message = "Enter your first name."
            }else if lastName.replacingOccurrences(of: " ", with: "") == "" {
                message = "Enter your last name."
            }else if login.replacingOccurrences(of: " ", with: "") == "" {
                message = "Enter login."
            }else if password == "" {
                message = "Enter password."
            }else if repeatPassword == "" {
                message = "Confirm password."
            }else if selectedCountry == nil {
                message = "Choose a country of origin."
            }else if repeatPassword != password {
                message = "Password and confirm password does not match."
            }
            let errorCode = try await performRequestLogin(urlS: urlS)
            if errorCode == -1 {
                message = "Failed to read the data from the server."
            }else if errorCode == 0 {
                message = "Login already exists."
            }
            if message != "" {
                delegate?.showErrorMessage(message: message)
            }else {
                let hashedPassword = SHA256.hash(data: Data(password.utf8)).description.replacingOccurrences(of: "SHA256 digest: ", with: "")
                let urlS = K.URLs.insertPassengerURL + "?firstN=\(firstName)&lastN=\(lastName)&password=\(hashedPassword)&login=\(login)&countryID=\(selectedCountry!)"
                performRequestPassenger(urlS: urlS)
            }
        }
    }
    func performRequestPassenger(urlS: String) {
        if let url = URL(string: urlS) {
            URLSession.shared.dataTask(with: url) { data, response, error in
                if error != nil {
                    self.delegate?.showErrorMessage(message: "Failed to load data.")
                }else {
                    if let data = data {
                        self.parseJSONPassenger(data: data)
                    }
                }
            }.resume()
        }
    }
    
    func parseJSONPassenger(data: Data) {
        let decoder = JSONDecoder()
        do {
            let decodedData = try decoder.decode(Answer.self, from: data)
            if let answer = decodedData.answer {
                if answer  {
                    delegate?.showSuccessMessage(message: "The account was successively created.")
                }else {
                    delegate?.showErrorMessage(message: "Failed to create an account. Try again later.")
                }
            }else {
                delegate?.showErrorMessage(message: "Failed to get a response from the server.")
            }
        }catch {
            delegate?.showErrorMessage(message: "Failed to parse data.")
        }
    }
}

//MARK: - Country loading
extension RegistrationManager: CountryLoader {
    func downloadCountries() {
        let urlStr = K.URLs.loadCountriesURL
        performRequestCountry(urlS: urlStr)
    }
    
    func performRequestCountry(urlS: String) {
        if let url = URL(string: urlS) {
            URLSession.shared.dataTask(with: url) { data, response, error in
                if error != nil {
                    self.delegate?.showErrorMessage(message: "Failed to load data.")
                }else {
                    if let data = data {
                        self.parseJSONCountry(data: data)
                    }
                }
            }.resume()
        }
    }
    
    func parseJSONCountry(data: Data) {
        let decoder = JSONDecoder()
        
        do {
            let decodedData = try decoder.decode([Country].self, from: data)
            
            for c in decodedData {
                if let name = c.countryName, let id = c.ID {
                    pickerData.append(name)
                    countries[name] = id
                }
            }
            delegate?.updateCountryPickerView()
        }catch {
            delegate?.showErrorMessage(message: "Failed to parse data.")
        }
    }
}
