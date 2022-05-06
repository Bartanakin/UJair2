//
//  RegistrationManager.swift
//  buyTickets
//
//  Created by Alexey Valevich on 06/05/2022.
//

import Foundation
import CryptoKit

class RegistrationManager {
    var countries: [String : Int] = [String : Int]()
    var pickerData = [String]()
    var selectedCountry: Int?
    weak var delegate: RegistrationManagerDelegate?
    
    func downloadCountries() async {
        
    }
    
    func setSelectedCountry(to: String) {
        selectedCountry = countries[to]
    }
    
    func insertPassenger(firstName: String, lastName: String, login: String, password: String, repeatPassword: String) {
        var message: String
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
    }
}
