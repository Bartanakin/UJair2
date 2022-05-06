//
//  ViewController.swift
//  buyTickets
//
//  Created by Alexey Valevich on 12/01/2022.
//

import UIKit

protocol LoginManagerDelegate: AnyObject {
    func showErrorMessage(message: String);
    func updateController();
}

class LoginViewController: UIViewController {

    @IBOutlet var loginField: CustomUIField!
    @IBOutlet var passwordField: CustomUIField!
    @IBOutlet var signInbutton: UIButton!
    @IBOutlet var registerButton: UIButton!
    var loginManager = LoginManager()
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        loginField.setProperties(TextFieldProperties())
        passwordField.setProperties(TextFieldProperties())
        
        loginField.delegate = self
        passwordField.delegate = self
        loginManager.delegate = self
        
        title = "Register or Sign In"
    }
    
    override func viewWillAppear(_ animated: Bool) {
        passwordField.text = ""
        loginField.text = ""
    }
    
    override func touchesBegan(_ touches: Set<UITouch>, with event: UIEvent?) {
        view.endEditing(true)
    }
    
    @IBAction func registerTapped(_ sender: Any) {
        self.performSegue(withIdentifier: K.Segues.loginToRegister, sender: self)
    }
    
    
    
    @IBAction func signInTapped(_ sender: Any) {
        let login = loginField.text ?? ""
        let password = passwordField.text ?? ""
        
        loginManager.checkCredentials(login: login, password: password)
    }
}

//MARK: - UITextFieldDelegate
extension LoginViewController: UITextFieldDelegate {
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
    
    func textFieldShouldReturn(_ textField: UITextField) -> Bool {
        view.endEditing(true)
    }
}

//MARK: - LoginManagerDelegate
extension LoginViewController: LoginManagerDelegate {
    func showErrorMessage(message: String) {
        DispatchQueue.main.async {
            self.loginField.text = ""
            self.passwordField.text = ""
            let ac = UIAlertController(title: "Fail", message: message, preferredStyle: .alert)
            ac.addAction(UIAlertAction(title: "OK", style: .default, handler: nil))
            self.present(ac, animated: true, completion: nil)
        }
    }
    
    func updateController() {
        DispatchQueue.main.async {
            self.performSegue(withIdentifier: K.Segues.loginToBooking, sender: self)
        }
    }
}
