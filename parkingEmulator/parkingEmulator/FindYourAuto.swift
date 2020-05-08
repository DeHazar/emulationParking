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
    @EnvironmentObject var viewModel: CarViewModel

    var body: some View {
        VStack {
            Text("Найдите свою машину").fontWeight(.black).padding()
            TextField("Номер Машины", text: $findingAutoString).textFieldStyle(RoundedBorderTextFieldStyle()).padding()

            Button(action: {
                self.viewModel.fetchWithCode(code: self.findingAutoString, parkingId: self.item.id)
            }) {
                Text("Найти").fontWeight(.bold).padding()
            }.padding()

            viewModel.resource.isLoading() {
                Group  {
                    Spacer()
                    LoadingView()
                    Spacer()
                }
            }

            viewModel.resource.hasError() { error in
                //                print($0)
                ErrorView(str: error.localizedDescription)
            }

            viewModel.resource.hasResource() { auto in
                List {
                    ForEach (auto,id: \.id) { item in
                        VStack {
                        if item.isPaid {
                            CarViewRow(item: item)
                        } else {
                            NavigationLink(destination: PayingView(item: self.item, parkingAuto: item)
                                .environmentObject(PaidViewModel(with: ParkingNetwork()))) {
                                CarViewRow(item: item)
                            }
                        }
                    }
                    }
                }
            }

        }.navigationBarTitle(item.address)
        
    }
}

struct FindYourAuto_Previews: PreviewProvider {
    static var previews: some View {
        FindYourAuto(item: Parking(id: "2", emptyPlaces: "233", address: "Парковка"))
    }
}
