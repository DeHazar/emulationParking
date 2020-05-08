//
//  NetworkRoute.swift
//  parkingEmulator
//
//  Created by Denchik on 07.05.2020.
//  Copyright © 2020 UGATU. All rights reserved.
//

import Foundation

protocol NetworkRoute {

    var path: String { get }
    var method: NetworkMethod { get }
    var headers: [String: String]? { get }
}

extension NetworkRoute {

    var headers: [String : String]? {
        return nil
    }

    func create(for enviroment: NetworkEnvironment) -> URLRequest {

        var request = URLRequest(url: URL(string: enviroment.rawValue + path)!)
        request.allHTTPHeaderFields = headers
        request.httpMethod = method.rawValue.uppercased()

        return request
    }
}
