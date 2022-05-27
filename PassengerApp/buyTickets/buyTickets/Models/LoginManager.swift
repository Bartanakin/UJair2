//
//  LoginManager.swift
//  buyTickets
//
//  Created by Alexey Valevich on 05/05/2022.
//

import Foundation
import CryptoKit

class LoginManager {
    var passengerID: Int?
    weak var delegate: LoginManagerDelegate?
    
    func checkCredentials(login: String, password: String) {
        if password == "" {
            delegate?.showErrorMessage(message: "Enter your login")
        }else if login == "" {
            delegate?.showErrorMessage(message: "Enter your password")
        }else {
            let hashedPassword = SHA256.hash(data: Data(password.utf8)).description.replacingOccurrences(of: "SHA256 digest: ", with: "")
            
            let url = K.URLs.getPassengerIDIfExistsURL + "?login=\(login)&password=\(password)"
            performRequest(url: url)
        }
    }
    
    func performRequest(url: String) {
        if let url = URL(string: url) {
            URLSession.shared.dataTask(with: url) { data, response, error in
                if(error != nil) {
                    self.delegate?.showErrorMessage(message: "Failed to load data.")
                }else {
                    if let data = data {
                        if let parsedData = self.parseJSON(data: data) {
                            if(parsedData == -1) {
                                self.delegate?.showErrorMessage(message: "Invalid login or password.")
                            }else {
                                self.delegate?.updateController()
                            }
                        }
                    }
                }
            }.resume()
        }
    }
    
    func parseJSON(data: Data) -> Int? {
        let decoder = JSONDecoder()
        
        do {
            let decodedData = try decoder.decode(Passenger.self, from: data)
            self.passengerID = decodedData.passengerID
            return decodedData.passengerID
        } catch {
            delegate?.showErrorMessage(message: "Error occured when parsing data.")
        }
        return nil
    }
}
