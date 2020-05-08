//
//  Parking.swift
//  parkingEmulator
//
//  Created by Denchik on 07.05.2020.
//  Copyright © 2020 UGATU. All rights reserved.
//

import Foundation

struct Parking: Codable {
    let id: String
    let emptyPlaces: String
    let address: String

    enum CodingKeys: String, CodingKey {
        case id
        case emptyPlaces = "carNumber"
        case address
    }
}
