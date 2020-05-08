//
//  ContentView.swift
//  parkingEmulator
//
//  Created by Denchik on 07.05.2020.
//  Copyright © 2020 UGATU. All rights reserved.
//

import SwiftUI

struct ContentView: View {
    @EnvironmentObject var viewModel: ParkingViewModel
    var body: some View {
        NavigationView{
            VStack {
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

                viewModel.resource.hasResource() { parking in
                    List {
                        ForEach (parking,id: \.id) { item in
                            NavigationLink(destination: FindYourAuto(item: item).environmentObject(CarViewModel(with: ParkingNetwork()))) {
                                ParkingViewRow(item: item)
                            }
                        }
                    }
                }

            }.onAppear(perform: viewModel.onAppear).navigationBarTitle("Парковки")
        }
    }
}

struct ContentView_Previews: PreviewProvider {
    static var previews: some View {
        ContentView().environmentObject(ParkingViewModel(with: ParkingNetwork()))
    }
}
