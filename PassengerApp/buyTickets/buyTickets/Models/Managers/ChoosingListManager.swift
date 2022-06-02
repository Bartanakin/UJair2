//
//  ChoosingListManager.swift
//  buyTickets
//
//  Created by Alex on 29/05/2022.
//

import Foundation

//MARK: - Airports Loader functions
extension ChoosingListManager {
    func performRequestAirport(urlS: String) {
        if let url = URL(string: urlS) {
            URLSession.shared.dataTask(with: url) { data, response, error in
                if error != nil {
                    self.delegate?.showErrorMessage(message: "Failed to get data from the server. Check your connection.")
                }else {
                    if let data = data {
                        self.parseJSONAirport(data: data)
                    }else {
                        self.delegate?.showErrorMessage(message: "Failed to get data from the server. Check your connection.")
                    }
                }
            }.resume()
        }
    }
    
    func parseJSONAirport(data: Data) {
        let decoder = JSONDecoder()
        do {
            airports = try decoder.decode([Airport].self, from: data)
            filteredData = airports
            delegate?.updateTableView()
        }catch {
            delegate?.showErrorMessage(message: "Failed to parse data.")
        }
    }
}

//MARK: - Schedule Loader functions
extension ChoosingListManager {
    func performRequestDate(urlS: String) {
        if let url = URL(string: urlS) {
            URLSession.shared.dataTask(with: url) { data, response, error in
                if error != nil {
                    self.delegate?.showErrorMessage(message: "Failed to get data from the server. Check your connection.")
                }else {
                    if let data = data {
                        self.parseJSONDate(data: data)
                    }else {
                        self.delegate?.showErrorMessage(message: "Failed to get data from the server. Check your connection.")
                    }
                }
            }.resume()
        }
    }
    
    func parseJSONDate(data: Data) {
        let decoder = JSONDecoder()
        do {
            routes = try decoder.decode([Route].self, from: data)
            filteredData = routes
            delegate?.updateTableView()
        }catch {
            delegate?.showErrorMessage(message: "Failed to parse data.")
        }
    }
}

class ChoosingListManager {
    var identifier: Int?
    var airports: [Airport]?
    var routes: [Route]?
    var filteredData: [Any]?
    weak var delegate: ChoosingListManagerDelegate?
    var selectedDeparturePlace: Int?
    var selectedDistanationPlace: Int?
    var selectedRoute: Int?
    
    func downloadData() {
        if identifier == K.ListType.Departure {
            performRequestAirport(urlS: K.URLs.downloadStartingAirportsURL)
        }else if identifier == K.ListType.Destination {
            let urlS = K.URLs.downloadTargetAirportsURL + "?start=\(selectedDeparturePlace!)"
            performRequestAirport(urlS: urlS)
        }else {
            let urlS = K.URLs.downloadScheduleURL + "?start=\(selectedDeparturePlace!)&target=\(selectedDistanationPlace!)"
            performRequestDate(urlS: urlS)
        }
    }
}
