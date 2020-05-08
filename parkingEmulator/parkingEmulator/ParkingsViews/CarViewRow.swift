//
//  CarViewRow.swift
//  parkingEmulator
//
//  Created by Denchik on 08.05.2020.
//  Copyright © 2020 UGATU. All rights reserved.
//

import SwiftUI

struct CheckView: View {
    @State var isChecked:Bool = false
    var title:String
    func toggle(){}
    var body: some View {
        Button(action: toggle){
            HStack{
                Image(systemName: isChecked ? "checkmark.square": "square")
                Text(title)
            }

        }
    }
}

struct CarViewRow: View {
    let item: Auto

    var body: some View {
        HStack{
            Text(item.id)
            Text(item.description)
            Spacer()
            HStack {
                VStack {
                    Text("Въезд").fontWeight(.medium)
                    Text(item.start_date).font(.system(size: 10))
                }
                VStack {
                    Text("Выезд").fontWeight(.medium)
                    Text(item.end_date ?? "").font(.system(size: 10))
                }
            }

            CheckView(isChecked: item.isPaid, title: "").padding(.leading, 10)

        }.padding()
    }
}

struct CarViewRow_Previews: PreviewProvider {
    static var previews: some View {
        CarViewRow(item: Auto(id: "2", carNumber: "asdasd", description: "asfdafs", transactionId: "12", start_date: "fd", end_date: nil, total: "213", isPaid: true))
    }
}
