//
//  ParkingViewModel.swift
//  parkingEmulator
//
//  Created by Denchik on 07.05.2020.
//  Copyright © 2020 UGATU. All rights reserved.
//

import SwiftUI
import Combine

class ParkingViewModel: NetworkViewModel, ObservableObject {

    typealias NetworkResource = [Parking]

    var resource: Resource<NetworkResource> = .loading
    var network: Network
    var route: NetworkRoute = ParkingRoute.parkings
    var bag: Set<AnyCancellable> = Set<AnyCancellable>()

    init(with network: Network) {
        self.network = network
    }
}
