//
//  BookingManager.swift
//  buyTickets
//
//  Created by Alex on 29/05/2022.
//

import Foundation

//MARK: - Seats Loader functions
extension BookingManager {
    func performRequest(urlS: String) {
        if let url = URL(string: urlS) {
            URLSession.shared.dataTask(with: url) { data, response, error in
                if error != nil {
                    self.delegate?.showErrorMessage(message: "Failed to get data from the server. Check your connection.")
                }else {
                    if let data = data {
                        self.parseJSON(data: data)
                    }
                }
            }.resume()
        }
    }
    
    func parseJSON(data: Data) {
        let decoder = JSONDecoder()
        do {
            availableSeats = try decoder.decode(Seats.self, from: data).seats
            delegate?.updatePicker()
        }catch {
            delegate?.showErrorMessage(message: "Error occured when parsing data.")
        }
    }
}

//MARK: - Insertion of Ticket functions
extension BookingManager {
    func insertTicket() {
        let urlS = K.URLs.insertTicketURL + "?flightID=\(selectedRoute!.ID!)&numberOfSeat=\(selectedSeat!)&passengerID=\(passengerID!)"
        performRequestTicket(urlS: urlS)
    }
    
    func performRequestTicket(urlS: String) {
        if let url = URL(string: urlS) {
            URLSession.shared.dataTask(with: url) { data, response, error in
                if error != nil {
                    self.delegate?.showErrorMessage(message: "Failed to download data from the server. Try again.")
                }else {
                    if let data = data {
                        self.parseJSONTicket(data: data)
                    }
                }
            }.resume()
        }
    }
    
    func parseJSONTicket(data: Data) {
        let decoder = JSONDecoder()
        do {
            let decodedData = try decoder.decode(Answer.self, from: data)
            if decodedData.answer == 0 {
                delegate?.showErrorMessage(message: "Ticket was not added. Try again.")
            }else {
                delegate?.showErrorMessage(message: "Ticket was successfully added.")
            }
            delegate?.clearSeatsPicker()
            delegate?.clearDatesField()
            delegate?.clearDestinationField()
            delegate?.clearDepartureField()
        }catch {
            delegate?.showErrorMessage(message: "Error occured when parsing data.")
        }
    }
}

class BookingManager {
    var selectedField: Int?
    weak var delegate: BookingManagerDelegate?
    var selectedDeparturePlace: Airport?
    var selectedDistanationPlace: Airport?
    var selectedRoute: Route?
    var availableSeats: [Int]?
    var selectedSeat: Int?
    var passengerID: Int?
    
    func canPerformSegue(destText: String?, depText: String?) -> Bool {
        let destText = destText ?? ""
        let depText = depText ?? ""
        
        if selectedField == K.ListType.Departure {
            delegate?.clearDestinationField()
            delegate?.clearDatesField()
            delegate?.clearSeatsPicker()
            return true
        }else if depText != "" && selectedField == K.ListType.Destination {
            delegate?.clearDatesField()
            delegate?.clearSeatsPicker()
            return true
        }else if destText != "" && selectedField == K.ListType.Dates {
            delegate?.clearSeatsPicker()
            return true
        }else {
            delegate?.showErrorMessage(message: "Choose something in previous fields.")
            return false
        }
    }
}
