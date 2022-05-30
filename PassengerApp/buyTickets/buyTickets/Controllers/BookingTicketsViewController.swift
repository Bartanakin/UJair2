//
//  BookingTicketsViewController.swift
//  buyTickets
//
//  Created by Alex on 27/05/2022.
//

import UIKit

protocol BookingManagerDelegate: AnyObject {
    func clearDestinationField()
    func clearDatesField()
    func showErrorMessage(message: String)
    func updatePicker()
    func clearSeatsPicker()
    func clearDepartureField()
    func showSuccessMessage(message: String)
}

//MARK: - Booking Manager Delegate functions
extension BookingTicketsViewController: BookingManagerDelegate {
    func clearDestinationField() {
        DispatchQueue.main.async {
            self.destinationField.text = ""
        }
    }
    
    func clearDatesField() {
        DispatchQueue.main.async {
            self.datesField.text = ""
        }
    }
    
    func clearDepartureField() {
        DispatchQueue.main.async {
            self.departureField.text = ""
        }
    }
    
    func clearSeatsPicker() {
        DispatchQueue.main.async {
            self.bookingManager.availableSeats = []
            self.updatePicker()
        }
    }
    
    func updatePicker() {
        DispatchQueue.main.async {
            self.seatPicker.delegate = self
        }
    }
    
    func showErrorMessage(message: String) {
        DispatchQueue.main.async {
            let ac = UIAlertController(title: "Fail", message: message, preferredStyle: .alert)
            ac.addAction(UIAlertAction(title: "OK", style: .default, handler: nil))
            self.present(ac, animated: true, completion: nil)
            
        }
    }
    
    func showSuccessMessage(message: String) {
        DispatchQueue.main.async {
            let ac = UIAlertController(title: "Success", message: message, preferredStyle: .alert)
            ac.addAction(UIAlertAction(title: "OK", style: .default, handler: nil))
            self.present(ac, animated: true, completion: nil)
            
        }
    }
}

//MARK: - TextField functions
extension BookingTicketsViewController: UITextFieldDelegate {
    func textFieldDidBeginEditing(_ textField: UITextField) {
        if textField == departureField {
            bookingManager.selectedField = K.ListType.Departure
        }else if textField == destinationField {
            bookingManager.selectedField = K.ListType.Destination
        }else {
            bookingManager.selectedField = K.ListType.Dates
        }
        if bookingManager.canPerformSegue(destText: destinationField.text, depText: departureField.text) {
            performSegue(withIdentifier: K.Segues.bookingToChoosingList, sender: self)
        }
        self.view.endEditing(true)
    }
}

//MARK: - ScrollView functions
extension BookingTicketsViewController: UIScrollViewDelegate {
    func scrollViewDidScroll(_ scrollView: UIScrollView) {
        view.endEditing(true)
    }
    
    @objc func scrollViewTapped() {
        view.endEditing(true)
    }
}

//MARK: - PickerView functions
extension BookingTicketsViewController: UIPickerViewDelegate, UIPickerViewDataSource {
    func numberOfComponents(in pickerView: UIPickerView) -> Int {
        1
    }
    
    func pickerView(_ pickerView: UIPickerView, numberOfRowsInComponent component: Int) -> Int {
        bookingManager.availableSeats?.count ?? 0
    }
    
    func pickerView(_ pickerView: UIPickerView, titleForRow row: Int, forComponent component: Int) -> String? {
        guard let count = bookingManager.availableSeats?.count else {
            return "?"
        }
        var seat: Int? = 0
        if row < count {
            seat = bookingManager.availableSeats?[row]
        }
        return String(seat ?? 0) == "0" ? "?" : String(seat!)
    }
    
    func pickerView(_ pickerView: UIPickerView, didSelectRow row: Int, inComponent component: Int) {
        bookingManager.selectedSeat = bookingManager.availableSeats?[row]
    }
}


class BookingTicketsViewController: UIViewController {
    
    @IBOutlet var scrollView: UIScrollView!
    
    @IBOutlet var destinationField: CustomUIField!
    @IBOutlet var departureField: CustomUIField!
    @IBOutlet var datesField: CustomUIField!
    @IBOutlet var seatPicker: UIPickerView!
    
    var bookingManager = BookingManager()
    
    override func viewDidLoad() {
        super.viewDidLoad()
        title = "Book Ticket"
        
        let scrollViewTap = UITapGestureRecognizer(target: self, action: #selector(scrollViewTapped))
        scrollView.addGestureRecognizer(scrollViewTap)
        
        navigationItem.rightBarButtonItem = UIBarButtonItem(title: "My Tickets", style: .plain, target: self, action: #selector(showMyTickets))
        
        destinationField.setProperties(TextFieldProperties())
        departureField.setProperties(TextFieldProperties())
        datesField.setProperties(TextFieldProperties())
        
        destinationField.delegate = self
        departureField.delegate = self
        datesField.delegate = self
        seatPicker.delegate = self
        scrollView.delegate = self
        bookingManager.delegate = self
        
        seatPicker.dataSource = self
    }
    
    @objc func showMyTickets() {
        performSegue(withIdentifier: K.Segues.bookingToAllTickets, sender: self)
    }
    
    override func touchesBegan(_ touches: Set<UITouch>, with event: UIEvent?) {
        view.endEditing(true)
    }
    
    override func prepare(for segue: UIStoryboardSegue, sender: Any?) {
        if segue.identifier == K.Segues.bookingToChoosingList {
            if let destinationVC = segue.destination as? ChoosingListViewController {
                if bookingManager.selectedField == K.ListType.Destination {
                    destinationVC.listManager.selectedDeparturePlace = bookingManager.selectedDeparturePlace?.ID
                }else if bookingManager.selectedField == K.ListType.Dates {
                    destinationVC.listManager.selectedDeparturePlace = bookingManager.selectedDeparturePlace?.ID
                    destinationVC.listManager.selectedDistanationPlace = bookingManager.selectedDistanationPlace?.ID
                }
                destinationVC.listManager.identifier = bookingManager.selectedField
                destinationVC.parentController = self
            }
        }else if segue.identifier == K.Segues.bookingToAllTickets {
            if let destinationVC = segue.destination as? MyTicketsViewController {
                destinationVC.myTicketsManager.passengerID = bookingManager.passengerID
            }
        }
    }
    
    override func viewWillAppear(_ animated: Bool) {
        view.endEditing(true)
    }
    
    @IBAction func buyTicketTapped(_ sender: UIButton) {
        //confirm
        bookingManager.insertTicket()
    }
}
