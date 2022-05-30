//
//  MyTicketsManager.swift
//  buyTickets
//
//  Created by Alex on 29/05/2022.
//

import Foundation
import DropDown

class MyTicketsManager {
    var passengerID: Int?
    var delegate: MyTicketsManagerDelegate?
    var tickets: [Ticket]?
    let dropDown = DropDown()
    func downloadTickets() {
        let urlS = K.URLs.downloadTicketsForPassengerURL + "?passID=\(passengerID!)"
        performRequest(urlS: urlS)
    }
    
    func setUpFilterList(height: CGFloat) {
        dropDown.dataSource = ["Date", "Starting Airport"]
        dropDown.direction = .bottom
        dropDown.bottomOffset = CGPoint(x: 0, y: Int(height))
        dropDown.selectionAction = { [unowned self] (index: Int, item: String) in
            if index == 0 {
                self.tickets?.sort(by: { t1, t2 in
                    let date1 = t1.dateOfDeparture!
                    let date2 = t2.dateOfDeparture!
                    let dateFormatter = DateFormatter()
                    dateFormatter.dateFormat = "yyyy-MM-dd HH:mm:ss"
                    return dateFormatter.date(from: date1)! < dateFormatter.date(from: date2)!
                })
            }else {
                self.tickets?.sort(by: { t1, t2 in
                    t1.start! < t2.start!
                })
            }
            delegate?.updateList()
        }
    }
    
    func performRequest(urlS: String) {
        if let url = URL(string: urlS) {
            URLSession.shared.dataTask(with: url) { data, response, error in
                if error != nil {
                    self.delegate?.showErrorMessage(message: "Error occured when downloading data from the server.")
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
            tickets = try decoder.decode([Ticket].self, from: data)
            delegate?.updateList()
        }catch {
            delegate?.showErrorMessage(message: "Failed to parse data.")
        }
    }
}
