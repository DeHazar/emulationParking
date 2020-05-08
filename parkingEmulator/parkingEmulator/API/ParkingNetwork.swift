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
}

import Foundation

enum ParkingRoute {
    case parkings
    case searchCars
}

extension ParkingRoute: NetworkRoute {

    var path: String {
        switch self {
        case .parkings:
            return "/parking/skuds/read.php"
        case .searchCars:
            return "/parking/cars/findCars.php?q={CarNumber}"
        }
    }

    var method: NetworkMethod {
        switch self {
        case .parkings:
            return .get
        case .searchCars:
            return .post
        }
    }
}
