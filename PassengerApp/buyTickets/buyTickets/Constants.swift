//
//  Constants.swift
//  buyTickets
//
//  Created by Alexey Valevich on 05/05/2022.
//

import Foundation

struct K {
    struct URLs {
        //dodać tokeny
        static let getPassengerIDIfExistsURL = "http://localhost:8002/getPassengerIDIfExists"
        static let verifyLoginURL = "http://localhost:8002/canAddLogin"
        static let loadCountriesURL = "http://localhost:8002/loadCountries"
        static let insertPassengerURL = "http://localhost:8002/insertPassenger"
        static let downloadStartingAirportsURL = "http://localhost:8002/getAllAirports"
    }
    
    struct Segues {
        static let loginToRegister = "LoginToRegister"
        static let loginToBooking = "LoginToBooking"
        static let bookingToAllTickets = "BookingToAllTickets"
        
    }
}
