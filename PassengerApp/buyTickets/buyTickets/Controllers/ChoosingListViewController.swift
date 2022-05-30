//
//  ChoosingListViewController.swift
//  buyTickets
//
//  Created by Alex on 29/05/2022.
//

import UIKit

protocol ChoosingListManagerDelegate: AnyObject {
    func showErrorMessage(message: String)
    func updateTableView()
}

//MARK: - Choosing List functions
extension ChoosingListViewController: ChoosingListManagerDelegate {
    func showErrorMessage(message: String) {
        DispatchQueue.main.async {
            let ac = UIAlertController(title: "Fail", message: message, preferredStyle: .alert)
            ac.addAction(UIAlertAction(title: "OK", style: .default, handler: nil))
            self.present(ac, animated: true, completion: nil)
        }
    }
    
    func updateTableView() {
        DispatchQueue.main.async {
            self.tableView.reloadData()
        }
    }
}

//MARK: - SearchBar functions
extension ChoosingListViewController: UISearchBarDelegate {
    func searchBar(_ searchBar: UISearchBar, textDidChange searchText: String) {
        if listManager.identifier == K.ListType.Destination || listManager.identifier == K.ListType.Departure {
            listManager.filteredData = searchText.isEmpty ? listManager.airports : listManager.airports?.filter { (item: Any) -> Bool in
                if let item = item as? Airport {
                    return item.Airport_name!.range(of: searchText, options: .caseInsensitive, range: nil, locale: nil) != nil
                }else if let item = item as? Route {
                    return item.DateTimeOfDeparture!.range(of: searchText, options: .caseInsensitive, range: nil, locale: nil) != nil
                }
                return true
            }
        }else {
            listManager.filteredData = searchText.isEmpty ? listManager.routes : listManager.routes?.filter { (item: Any) -> Bool in
                if let item = item as? Airport {
                    return item.Airport_name!.range(of: searchText, options: .caseInsensitive, range: nil, locale: nil) != nil
                }else if let item = item as? Route {
                    return item.DateTimeOfDeparture!.range(of: searchText, options: .caseInsensitive, range: nil, locale: nil) != nil
                }
                return true
            }
        }
        
        tableView.reloadData()
    }
}

//MARK: - Help functions
extension ChoosingListViewController {
    func setEmptyMessage(_ message: String) {
        let messageLabel = UILabel(frame: CGRect(x: 0, y: 0, width: self.tableView.bounds.size.width, height: self.tableView.bounds.size.height))
        messageLabel.text = message
        messageLabel.textColor = #colorLiteral(red: 0.2052094638, green: 0.411657393, blue: 0.7065321803, alpha: 1)
        messageLabel.numberOfLines = 0
        messageLabel.textAlignment = .center
        messageLabel.font = UIFont(name: "TrebuchetMS", size: 40)
        messageLabel.sizeToFit()

        self.tableView.backgroundView = messageLabel
        self.tableView.separatorStyle = .none
    }
    
    func restore() {
        self.tableView.backgroundView = nil
        self.tableView.separatorStyle = .singleLine
    }

}

class ChoosingListViewController: UITableViewController {
    
    @IBOutlet var searchBar: UISearchBar!
    var listManager = ChoosingListManager()
    var parentController: UIViewController? //change to delegate???

    override func viewDidLoad() {
        super.viewDidLoad()
        listManager.delegate = self
        searchBar.delegate = self
        
        let tableViewTap = UITapGestureRecognizer(target: self, action: #selector(tableViewTapped))
        tableView.addGestureRecognizer(tableViewTap)
        
        listManager.downloadData()
    }
    
    @objc func tableViewTapped() {
        searchBar.endEditing(true)
    }

    override func scrollViewDidScroll(_ scrollView: UIScrollView) {
        searchBar.endEditing(true)
    }

    override func numberOfSections(in tableView: UITableView) -> Int {
        return 1
    }

    override func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        if let count = listManager.filteredData?.count {
            if count == 0 {
                setEmptyMessage("No Results.")
            }else {
                restore()
            }
            return count
        }else {
            setEmptyMessage("No Results.")
        }
        
        return listManager.filteredData?.count ?? 0
    }
    
    override func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        
        let cell = tableView.dequeueReusableCell(withIdentifier: "OptionToChoose", for: indexPath)
        var content = cell.defaultContentConfiguration()
        if listManager.identifier == K.ListType.Dates {
            if let route = listManager.filteredData?[indexPath.row] as? Route {
                content.text = route.DateTimeOfDeparture
            }
        }else {
            if let airport = listManager.filteredData?[indexPath.row] as? Airport {
                content.text = airport.Airport_name
            }
        }
        cell.contentConfiguration = content
        return cell
    }
    
    override func tableView(_ tableView: UITableView, didSelectRowAt indexPath: IndexPath) {
        
        if let parentVC = self.parentController {
            
            if let parentVC = parentVC as? BookingTicketsViewController {
                if listManager.identifier == K.ListType.Departure {
                    if let airport = listManager.filteredData?[indexPath.row] as? Airport {
                        parentVC.bookingManager.selectedDeparturePlace = airport
                        parentVC.departureField.text = airport.Airport_name
                    }
                }else if listManager.identifier == K.ListType.Destination {
                    if let airport = listManager.filteredData?[indexPath.row] as? Airport {
                        parentVC.bookingManager.selectedDistanationPlace = airport
                        parentVC.destinationField.text = airport.Airport_name
                    }
                }else {
                    if let route = listManager.filteredData?[indexPath.row] as? Route {
                        parentVC.bookingManager.selectedRoute = route
                        parentVC.datesField.text = route.DateTimeOfDeparture
                        let urlS = K.URLs.downloadAvailableSeatsURL + "?flightID=\(route.ID!)"
                        parentVC.bookingManager.performRequest(urlS: urlS)
                    }
                }
                self.dismiss(animated: true)
            }
        }
    }
}