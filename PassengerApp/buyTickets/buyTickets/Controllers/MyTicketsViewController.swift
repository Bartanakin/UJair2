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
            self.tableView.reloadData()
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
}
class MyTicketsViewController: UITableViewController {
    
    @IBOutlet var filterButton: UIBarButtonItem!
    var myTicketsManager = MyTicketsManager()
    var topbarHeight: CGFloat {
        return (view.window?.windowScene?.statusBarManager?.statusBarFrame.height ?? 0.0) +
            (self.navigationController?.navigationBar.frame.height ?? 0.0)
    }
    override func viewDidLoad() {
        super.viewDidLoad()
        title = "My Tickets"
        myTicketsManager.delegate = self
        myTicketsManager.downloadTickets()
        
        myTicketsManager.dropDown.anchorView = filterButton
        myTicketsManager.setUpFilterList(height: topbarHeight)
        
        
        
    }
    
    @IBAction func filter(_ sender: Any) {
        myTicketsManager.dropDown.show()
    }

    override func numberOfSections(in tableView: UITableView) -> Int {
        return 1
    }

    override func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        if let count = myTicketsManager.tickets?.count {
            if count == 0 {
                setEmptyMessage("No Results.")
            }else {
                restore()
            }
            return count
        }else {
            setEmptyMessage("No Results.")
        }
        
        return myTicketsManager.tickets?.count ?? 0
    }

    
    override func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        let cell = tableView.dequeueReusableCell(withIdentifier: "Ticket", for: indexPath)
        var content = cell.defaultContentConfiguration()
        if let ticket = myTicketsManager.tickets?[indexPath.row] {
            content.text = ticket.start! + " -> " + ticket.target!
            content.secondaryText = ticket.dateOfDeparture
        }
        cell.contentConfiguration = content
        return cell
    }
    

    /*
    // Override to support conditional editing of the table view.
    override func tableView(_ tableView: UITableView, canEditRowAt indexPath: IndexPath) -> Bool {
        // Return false if you do not want the specified item to be editable.
        return true
    }
    */

    /*
    // Override to support editing the table view.
    override func tableView(_ tableView: UITableView, commit editingStyle: UITableViewCell.EditingStyle, forRowAt indexPath: IndexPath) {
        if editingStyle == .delete {
            // Delete the row from the data source
            tableView.deleteRows(at: [indexPath], with: .fade)
        } else if editingStyle == .insert {
            // Create a new instance of the appropriate class, insert it into the array, and add a new row to the table view
        }    
    }
    */

    /*
    // Override to support rearranging the table view.
    override func tableView(_ tableView: UITableView, moveRowAt fromIndexPath: IndexPath, to: IndexPath) {

    }
    */

    /*
    // Override to support conditional rearranging of the table view.
    override func tableView(_ tableView: UITableView, canMoveRowAt indexPath: IndexPath) -> Bool {
        // Return false if you do not want the item to be re-orderable.
        return true
    }
    */

    /*
    // MARK: - Navigation

    // In a storyboard-based application, you will often want to do a little preparation before navigation
    override func prepare(for segue: UIStoryboardSegue, sender: Any?) {
        // Get the new view controller using segue.destination.
        // Pass the selected object to the new view controller.
    }
    */

}
