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
        static let getPassengerIDIfExistsURL = "https://github.frege.ii.uj.edu.pl/getPassengerIDIfExists"
        static let verifyLoginURL = "https://github.frege.ii.uj.edu.pl/canAddLogin"
        static let loadCountriesURL = "https://github.frege.ii.uj.edu.pl/loadCountries"
        static let insertPassengerURL = "https://github.frege.ii.uj.edu.pl/insertPassenger"
        static let downloadStartingAirportsURL = "https://github.frege.ii.uj.edu.pl/getAllAirports"
        static let downloadTargetAirportsURL = "https://github.frege.ii.uj.edu.pl/getTargetAirports"
        static let downloadScheduleURL = "https://github.frege.ii.uj.edu.pl/getScheduleForRoute"
        static let downloadAvailableSeatsURL = "https://github.frege.ii.uj.edu.pl/getAvailableSeats"
        static let insertTicketURL = "https://github.frege.ii.uj.edu.pl/insertTicket"
        static let downloadTicketsForPassengerURL = "https://github.frege.ii.uj.edu.pl/getTicketsForPassengerID"
        
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
