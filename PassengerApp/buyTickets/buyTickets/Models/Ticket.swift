//
//  Ticket.swift
//  buyTickets
//
//

import Foundation

struct Ticket: Decodable {
    var start: String?
    var target: String?
    var numberOfSeat: Int?
    var dateOfDeparture: String?
}
