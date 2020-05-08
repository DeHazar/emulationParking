//
//  ParkingNetwork.swift
//  parkingEmulator
//
//  Created by Denchik on 07.05.2020.
//  Copyright © 2020 UGATU. All rights reserved.
//

import Foundation

struct ParkingNetwork: Network {
    var enviroment: NetworkEnvironment = .parkingUrl
    var decoder: JSONDecoder = JSONDecoder()
    var headers: [String: String]?
    var parametrs: [String: Any]?
}

import Foundation

enum ParkingRoute {
    case parkings
    case searchCars
    case getSum
    case paid
}

extension ParkingRoute: NetworkRoute {
    var path: String {
        switch self {
        case .parkings:
            return "/parking/skuds/read.php"
        case .searchCars:
            return "/parking/cars/search.php"
        case .getSum:
            return "/parking/cars/total.php"
        case .paid:
            return "/parking/cars/paid.php"
        }
    }

    var method: NetworkMethod {
        switch self {
        case .parkings:
            return .get
        case .searchCars:
            return .post
        case .getSum:
            return .post
        case .paid:
            return .post
        }
    }
}
