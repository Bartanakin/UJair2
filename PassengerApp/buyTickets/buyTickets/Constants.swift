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
        static let downloadTargetAirportsURL = "http://localhost:8002/getTargetAirports"
        static let downloadScheduleURL = "http://localhost:8002/getScheduleForRoute"
        static let downloadAvailableSeatsURL = "http://localhost:8002/getAvailableSeats"
        static let insertTicketURL = "http://localhost:8002/insertTicket"
        static let downloadTicketsForPassengerURL = "http://localhost:8002/getTicketsForPassengerID"
        
    }
    
    struct Segues {
        static let loginToRegister = "LoginToRegister"
        static let loginToBooking = "LoginToBooking"
        static let bookingToAllTickets = "BookingToAllTickets"
        static let bookingToChoosingList = "BookingToChoosingList"
        
    }
    
    struct ListType {
        static let Departure = 1
        static let Destination = 2
        static let Dates = 3
    }
    
    struct TicketType {
        static let canceled = 1
        static let active = 2
        static let finished = 3
    }
    
    static let dateFormat = "yyyy-MM-dd HH:mm:ss"
}
