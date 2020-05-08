//
//  PayingView.swift
//  parkingEmulator
//
//  Created by Denchik on 08.05.2020.
//  Copyright © 2020 UGATU. All rights reserved.
//

import SwiftUI

struct PayingView: View {
    var item: Parking
    var parkingAuto: Auto
    @EnvironmentObject var viewModel: PaidViewModel
    @State var selection: Int? = nil

    var body: some View {
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

            viewModel.resource.hasResource() { trans in
                Text("Оплата парковки")
                Text("К оплате по №\(self.parkingAuto.id): \(trans.total) у.е.").fontWeight(.bold)
                HStack {
                    Text("Номер машины: ").fontWeight(.medium)
                    Text("\(self.parkingAuto.carNumber)")
                }

                Text("Прошло времени")
                Text(self.getTime(trans: trans))
                Spacer()
                NavigationLink(destination: PaidView(parkingAuto: self.parkingAuto)
                .environmentObject(PaidViewModel(with: ParkingNetwork())),
                               tag: 1, selection: self.$selection) {
                    Button(action: {
                        print("pay tapped")
                        self.selection = 1
                    }) {
                        HStack {
                            Spacer()
                            Text("Оплатить").foregroundColor(Color.white).bold()
                            Spacer()
                        }
                    }
                    .accentColor(Color.black)
                    .padding()
                    .background(Color(UIColor.darkGray))
                    .cornerRadius(4.0)
                    .padding(Edge.Set.vertical, 20).padding([.leading, .trailing], 10)
                }
                Spacer()
            }
        }.onAppear {
            self.viewModel.getSum(id: self.parkingAuto.id)
        }
    }

    func getTime(trans: Transaction) -> String {
        if let firstTime = trans.startTime.toDate(),
            let endTime = trans.endTime.toDate(){
            let total = endTime.timeIntervalSince1970 - firstTime.timeIntervalSince1970
            return "\(total) секунд"
        } else {
            let firstTime = trans.startTime.toDate()
            return "\(firstTime?.timeIntervalSinceNow)"
        }
    }
}

struct PaidView: View {
    var parkingAuto: Auto
    @EnvironmentObject var viewModel: PaidViewModel

    var body: some View {
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
                ErrorView(str: "Прозошла ошибка при оплате")
            }

            viewModel.resource.hasResource() { trans in
                VStack{
                Text("Вы успешно оплатили парковку").font(.system(size: 20))
                Text("У вас есть 5 минут, чтобы выехать из парковки. В ином случае, вам придеться доплачивать.").font(.system(size: 14))
                }.onAppear {
                    DispatchQueue.main.asyncAfter(deadline: .now() + 2) {
                        let scene = UIApplication.shared.connectedScenes.first
                        let contentView = ContentView()
                       let viewModel = ParkingViewModel(with: ParkingNetwork())
                        if let sd : SceneDelegate = (scene?.delegate as? SceneDelegate) {
                            sd.window?.rootViewController = UIHostingController(rootView: contentView.environmentObject(viewModel))
                        }
                    }
                }
            }
        }.onAppear {
            self.viewModel.paidSum(id: self.parkingAuto.id)
        }
    }
}

struct PayingView_Previews: PreviewProvider {
    static var previews: some View {
        PayingView(item: Parking(id: "32", emptyPlaces: "324", address: "ads"), parkingAuto: Auto(id: "", carNumber: "", description: "", transactionId: "", start_date: "", end_date: nil, total: "", isPaid: false))
    }
}
