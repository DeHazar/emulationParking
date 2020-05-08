//
//  PaidViewModel.swift
//  parkingEmulator
//
//  Created by Denchik on 08.05.2020.
//  Copyright © 2020 UGATU. All rights reserved.
//

import SwiftUI
import Combine

class PaidViewModel: NetworkViewModel, ObservableObject {

    typealias NetworkResource = Transaction

    var resource: Resource<NetworkResource> = .loading
    var network: Network
    var route: NetworkRoute = ParkingRoute.getSum
    var bag: Set<AnyCancellable> = Set<AnyCancellable>()

    init(with network: Network) {
        self.network = network
    }

    func fetchWithCode(code: String, parkingId: String) {
        self.network.parametrs = [:]
        self.network.parametrs!["carNumber"] = code as AnyObject
        self.network.parametrs!["parkingId"] = parkingId as AnyObject

        onAppear()
    }

    func getSum(id: String) {
        route = ParkingRoute.getSum
        self.network.parametrs = [:]
        self.network.parametrs!["id"] = id as AnyObject

        onAppear()
    }

    func paidSum(id: String) {
        route = ParkingRoute.paid
        self.network.parametrs = [:]
        self.network.parametrs!["id"] = id as AnyObject

        onAppear()
    }
}

