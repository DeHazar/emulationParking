//
//  Car.swift
//  parkingEmulator
//
//  Created by Denchik on 08.05.2020.
//  Copyright © 2020 UGATU. All rights reserved.
//

import Foundation

struct Auto: Codable {
    let id: String
    let carNumber: String
    let description: String
    let transactionId: String
    let start_date: String
    let end_date: String?
    let total: String
    let isPaid: Bool
}
