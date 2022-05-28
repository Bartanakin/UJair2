//
//  BookingTicketsViewController.swift
//  buyTickets
//
//  Created by Alex on 27/05/2022.
//

import UIKit
import SearchTextField

class BookingTicketsViewController: UIViewController, UITextFieldDelegate, UIScrollViewDelegate, UIPickerViewDelegate, UIPickerViewDataSource {
    
    
    
    @IBOutlet var scrollView: UIScrollView!
    @IBOutlet var destinationField: CustomUIField!
    @IBOutlet var departureField: CustomUIField!
    @IBOutlet var datesField: CustomUIField!
    @IBOutlet var seatPicker: UIPickerView!
    
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        let scrollViewTap = UITapGestureRecognizer(target: self, action: #selector(scrollViewTapped))
        scrollView.addGestureRecognizer(scrollViewTap)
        
        destinationField.setPropertiesAndDownloadData(TextFieldProperties(), from: K.URLs.downloadStartingAirportsURL)
        
        destinationField.delegate = self
        departureField.delegate = self
        datesField.delegate = self
        seatPicker.delegate = self
        scrollView.delegate = self
        
        seatPicker.dataSource = self
    }
    
    func numberOfComponents(in pickerView: UIPickerView) -> Int {
        1
    }
    
    func pickerView(_ pickerView: UIPickerView, numberOfRowsInComponent component: Int) -> Int {
        
    }
    
    override func touchesBegan(_ touches: Set<UITouch>, with event: UIEvent?) {
        destinationField.hideResultsList()
        view.endEditing(true)
    }
    
    func scrollViewDidScroll(_ scrollView: UIScrollView) {
        destinationField.hideResultsList()
        view.endEditing(true)
    }
    
    func textFieldDidBeginEditing(_ textField: UITextField) {
        destinationField.startVisibleWithoutInteraction = true
    }
    
    @objc func scrollViewTapped() {
        destinationField.hideResultsList()
        view.endEditing(true)
    }
}
