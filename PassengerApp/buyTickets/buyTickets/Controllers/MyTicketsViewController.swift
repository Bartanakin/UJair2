//
//  MyTicketsViewController.swift
//  buyTickets
//
//  Created by Alex on 29/05/2022.
//

import UIKit
import DropDown

protocol MyTicketsManagerDelegate {
    func showErrorMessage(message: String)
    func updateList()
    func setEmptyMessage(_ message: String)
    func restore()
    func endRefreshing()
}

extension MyTicketsViewController: MyTicketsManagerDelegate {
    func showErrorMessage(message: String) {
        DispatchQueue.main.async {
            let ac = UIAlertController(title: "Fail", message: message, preferredStyle: .alert)
            ac.addAction(UIAlertAction(title: "OK", style: .default, handler: nil))
            self.present(ac, animated: true, completion: nil)
        }
    }
    
    func updateList() {
        DispatchQueue.main.async {
            UIView.transition(with: self.tableView,
                              duration: 0.35,
                              options: .transitionCrossDissolve,
                              animations: { () -> Void in
                                self.tableView.reloadData()
                              },
                              completion: nil);
        }
    }
    
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
    
    func endRefreshing() {
        DispatchQueue.main.async {
            self.tableView.refreshControl?.endRefreshing()
        }
    }
}
class MyTicketsViewController: UITableViewController, UISearchBarDelegate {
    
    @IBOutlet var filterButton: UIBarButtonItem!
    @IBOutlet var searchBar: UISearchBar!
    var myTicketsManager = MyTicketsManager()
    var topbarHeight: CGFloat {
        return (view.window?.windowScene?.statusBarManager?.statusBarFrame.height ?? 0.0) +
            (self.navigationController?.navigationBar.frame.height ?? 0.0)
    }
    override func viewDidLoad() {
        super.viewDidLoad()
        title = "My Tickets"
        myTicketsManager.delegate = self
        searchBar.delegate = self
        myTicketsManager.downloadTickets()
        
        myTicketsManager.dropDown.anchorView = filterButton
        myTicketsManager.setUpFilterList(height: topbarHeight)
        
        let tableViewTap = UITapGestureRecognizer(target: self, action: #selector(tableViewTapped))
        tableView.addGestureRecognizer(tableViewTap)
        
        let refreshControl = UIRefreshControl()
        tableView.refreshControl = refreshControl
        refreshControl.addTarget(self, action: #selector(refreshWeatherData(_:)), for: .valueChanged)
    }
    
    @objc private func refreshWeatherData(_ sender: Any) {
        myTicketsManager.downloadTickets()
    }
    
    @IBAction func filter(_ sender: Any) {
        myTicketsManager.dropDown.show()
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
        if let count = myTicketsManager.filteredData?.count {
            if count == 0 {
                setEmptyMessage("No Results.")
            }else {
                restore()
            }
            return count
        }
        
        return myTicketsManager.filteredData?.count ?? 0
    }

    
    override func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        let cell = tableView.dequeueReusableCell(withIdentifier: "Ticket", for: indexPath)
        var content = cell.defaultContentConfiguration()
        if let ticket = myTicketsManager.filteredData?[indexPath.row] {
            content.text = ticket.start! + " -> " + ticket.target!
            content.secondaryText = ticket.dateOfDeparture! + " Seat: " + String(ticket.numberOfSeat!)
        }
        cell.contentConfiguration = content
        return cell
    }
    
    func searchBar(_ searchBar: UISearchBar, textDidChange searchText: String) {
        myTicketsManager.filteredData = searchText.isEmpty ? myTicketsManager.tickets : myTicketsManager.tickets?.filter { (item: Ticket) -> Bool in
            return item.start!.range(of: searchText, options: .caseInsensitive, range: nil, locale: nil) != nil || item.target!.range(of: searchText, options: .caseInsensitive, range: nil, locale: nil) != nil ||
                item.dateOfDeparture!.range(of: searchText, options: .caseInsensitive, range: nil, locale: nil) != nil
        }
        tableView.reloadData()
    }

}
