//
//  LoginTests.swift
//  LoginTests
//
//  Created by Alexey Valevich on 06/05/2022.
//

import XCTest
@testable import buyTickets



class LoginTests: XCTestCase {
    var sut: LoginManager!
    override func setUpWithError() throws {
        // Put setup code here. This method is called before the invocation of each test method in the class.
        try super.setUpWithError()
        sut = LoginManager()

    }

    override func tearDownWithError() throws {
        // Put teardown code here. This method is called after the invocation of each test method in the class.
        sut = nil
        try super.tearDownWithError()
    }
    
    func testCheckReturnPassengerID() async {
        //given
        let login = "login"
        let password = "password"
        //when
        do {
            try await sut.checkCredentials(login: login, password: password)
        }catch {
            
        }
        //then
        XCTAssertEqual(sut.passengerID ?? 0, 1, "Return wrong passenger ID")
    }

}
