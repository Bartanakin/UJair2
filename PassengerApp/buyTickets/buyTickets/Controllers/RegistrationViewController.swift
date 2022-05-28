//
//  RegistrationViewController.swift
//  buyTickets
//

import UIKit


protocol RegistrationManagerDelegate: AnyObject {
    func showErrorMessage(message: String)
    func showSuccessMessage(message: String)
    func updateCountryPickerView()
}

class RegistrationViewController: UIViewController, UIPickerViewDataSource {

    @IBOutlet var firstNameField: CustomUIField!
    @IBOutlet var lastNameField: CustomUIField!
    @IBOutlet var loginField: CustomUIField!
    @IBOutlet var passwordField: CustomUIField!
    @IBOutlet var repeatPasswordField: CustomUIField!
    @IBOutlet var countryPicker: UIPickerView!
    
    var registrationManager = RegistrationManager()
    
    override func viewDidLoad() {
        super.viewDidLoad()
        title = "Registration"
        
        loginField.setProperties(TextFieldProperties())
        passwordField.setProperties(TextFieldProperties())
        firstNameField.setProperties(TextFieldProperties())
        lastNameField.setProperties(TextFieldProperties())
        repeatPasswordField.setProperties(TextFieldProperties())
        
        registrationManager.delegate = self
        loginField.delegate = self
        passwordField.delegate = self
        firstNameField.delegate = self
        lastNameField.delegate = self
        repeatPasswordField.delegate = self
        countryPicker.delegate = self
        countryPicker.dataSource = self
        
        registrationManager.downloadCountries()
        
    }
    
    override func touchesBegan(_ touches: Set<UITouch>, with event: UIEvent?) {
        view.endEditing(true)
    }
    
    @IBAction func registerTapped(_ sender: Any) {
        let password = passwordField.text ?? ""
        let login = loginField.text ?? ""
        let firstName = firstNameField.text ?? ""
        let lastName = lastNameField.text ?? ""
        let repeatedPassword = repeatPasswordField.text ?? ""
        registrationManager.insertPassenger(firstName: firstName, lastName: lastName, login: login, password: password, repeatPassword: repeatedPassword)
    }
}

//MARK: - UITextFieldDelegate
extension RegistrationViewController: UITextFieldDelegate {
    func textFieldShouldReturn(_ textField: UITextField) -> Bool {
        view.endEditing(true)
    }

    func textFieldDidBeginEditing(_ textField: UITextField) {
        if let textField = textField as? CustomUIField {
            textField.setProperties(TextFieldProperties(borderWidth: 1, borderColor: CGColor(red: 220, green: 220, blue: 220, alpha: 0.7)))
        }
    }

    func textFieldDidEndEditing(_ textField: UITextField) {
        if let textField = textField as? CustomUIField {
            textField.setProperties(TextFieldProperties(borderWidth: 0.7, borderColor: CGColor(red: 169, green: 169, blue: 169, alpha: 0.4)))
        }
    }
}


//MARK: - UIPickerViewDelegate
extension RegistrationViewController: UIPickerViewDelegate {
    func numberOfComponents(in pickerView: UIPickerView) -> Int {
        return 1
    }
    
    func pickerView(_ pickerView: UIPickerView, numberOfRowsInComponent component: Int) -> Int {
        return registrationManager.pickerData.count
    }
    
    func pickerView(_ pickerView: UIPickerView, titleForRow row: Int, forComponent component: Int) -> String? {
        return registrationManager.pickerData[row]
    }
    
    func pickerView(_ pickerView: UIPickerView, didSelectRow row: Int, inComponent component: Int) {
        registrationManager.setSelectedCountry(to: registrationManager.pickerData[row])
    }
}

//MARK: - RegistrationManagerDelegate
extension RegistrationViewController: RegistrationManagerDelegate {
    func showErrorMessage(message: String) {
        DispatchQueue.main.async {
            self.loginField.text = ""
            self.passwordField.text = ""
            self.repeatPasswordField.text = ""
            let ac = UIAlertController(title: "Fail", message: message, preferredStyle: .alert)
            ac.addAction(UIAlertAction(title: "OK", style: .default, handler: nil))
            self.present(ac, animated: true, completion: nil)
        }
    }
    
    func showSuccessMessage(message: String) {
        DispatchQueue.main.async {
            let ac = UIAlertController(title: "Success", message: message, preferredStyle: .alert)
            ac.addAction(UIAlertAction(title: "OK", style: .default, handler: { _ in
                    self.navigationController?.popViewController(animated: true)
                }))
            self.present(ac, animated: true, completion: nil)
            
        }
    }
    
    func updateCountryPickerView() {
        DispatchQueue.main.async {
            self.countryPicker.delegate = self
        }
    }
}
