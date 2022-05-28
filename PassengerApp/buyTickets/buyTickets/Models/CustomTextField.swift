//
//  CustomField.swift
//  buyTickets
//
//  Created by Alexey Valevich on 05/05/2022.
//

import UIKit
import SearchTextField

class CustomUIField: SearchTextField {
    public func setProperties(_ properties: TextFieldProperties) {
        self.layer.borderWidth = properties.borderWidth
        self.layer.cornerRadius = properties.cornerRadius
        self.layer.borderColor = properties.borderColor
    }
    
    public func setPropertiesAndDownloadData(_ properties: TextFieldProperties, from url: String) {
        setProperties(properties)
        self.maxResultsListHeight = 68
        self.theme.font = UIFont.systemFont(ofSize: 14)
        if self.traitCollection.userInterfaceStyle == .dark {
            self.theme = SearchTextFieldTheme.darkTheme()
        }
        self.filterStrings(["Red", "Blue", "White", "Green"])
    }
    
    
}
