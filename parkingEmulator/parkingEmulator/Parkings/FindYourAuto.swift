//
//  FindYourAuto.swift
//  parkingEmulator
//
//  Created by Denchik on 07.05.2020.
//  Copyright © 2020 UGATU. All rights reserved.
//

import SwiftUI

struct FindYourAuto: View {
    var item: Parking
    @State var findingAutoString: String = ""

    var body: some View {
        VStack {
            Text("Найдите свою машину").fontWeight(.black)
            TextField("Номер Машины", text: $findingAutoString).textFieldStyle(RoundedBorderTextFieldStyle())

            }.padding().navigationBarTitle(item.address)
    }
}

struct FindYourAuto_Previews: PreviewProvider {
    static var previews: some View {
        FindYourAuto(item: Parking(id: "2", emptyPlaces: "233", address: "Парковка"))
    }
}
