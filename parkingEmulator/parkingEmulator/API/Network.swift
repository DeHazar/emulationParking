//
//  Network.swift
//  parkingEmulator
//
//  Created by Denchik on 07.05.2020.
//  Copyright © 2020 UGATU. All rights reserved.
//

import Foundation
import Combine

protocol Network {

    var decoder: JSONDecoder { get set }
    var enviroment: NetworkEnvironment { get set }
}

extension Network {

    func fetch<T: Decodable>(route: NetworkRoute) -> AnyPublisher<T, Error> {

        let request = route.create(for: enviroment)

        return URLSession.shared
            .dataTaskPublisher(for: request)
            .tryCompactMap { result in
                try self.decoder.decode(T.self, from: result.data)
            }
            .receive(on: RunLoop.main)
            .eraseToAnyPublisher()
    }
}
