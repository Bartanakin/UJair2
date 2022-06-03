//
//  RegistrationTests.swift
//  LoginTests
//
//  Created by Alexey Valevich on 06/05/2022.
//

import XCTest
@testable import buyTickets

class RegistrationTests: XCTestCase {
    var sut: RegistrationManager!
    override func setUpWithError() throws {
        // Put setup code here. This method is called before the invocation of each test method in the class.
        try super.setUpWithError()
        sut = RegistrationManager()
    }

    override func tearDownWithError() throws {
        // Put teardown code here. This method is called after the invocation of each test method in the class.
        sut = nil
        try super.tearDownWithError()
    }
    
    
    func testDownloadCountries() async{
        //given
        let expected = [String]()
        //when
        await sut.downloadCountries()
        
        //then
        XCTAssertEqual(Array(sut.countries.keys).sorted(by: { a, b in
            a < b
        }), expected, "Return wrong passenger ID")
    }

}
