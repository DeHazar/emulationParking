//
//  ParkingView.swift
//  parkingEmulator
//
//  Created by Denchik on 07.05.2020.
//  Copyright © 2020 UGATU. All rights reserved.
//

import SwiftUI

struct ParkingViewRow: View {
    let item: Parking

    var body: some View {
        HStack {
            Text("\(item.id)").font(
                .system(size: 24, weight: .bold, design: .default))
                .foregroundColor(.gray)
                .offset(x: 10, y: 0)
            Text(item.address)
            .offset(x: 30, y: 0)
            Spacer()
            VStack {
                Text("Свободных мест")

                Text("\(item.emptyPlaces)").fontWeight(.medium)
                    .foregroundColor(.green)
            }
        }
    }
}

struct ParkingView_Previews: PreviewProvider {
    static var previews: some View {
        ParkingViewRow(item: Parking(id: "1", emptyPlaces: "230", address: "Tarar"))
    }
}
