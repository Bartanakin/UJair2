//
//  Country.swift
//  buyTickets
//
//  Created by Alexey Valevich on 12/01/2022.
//

import UIKit

class Country: NSObject {
    var id: String?
    var name: String?
    
    override init() {
        
    }
    
    init(id: String, name: String) {
        
        self.id = id
        self.name = name
        
    }
}
