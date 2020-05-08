//
//  Transaction.swift
//  parkingEmulator
//
//  Created by Denchik on 08.05.2020.
//  Copyright © 2020 UGATU. All rights reserved.
//

import Foundation

struct Transaction: Codable {
    let transactionId: String
    let total: Double
    let startTime: String
    let endTime: String
    let message: String
}
