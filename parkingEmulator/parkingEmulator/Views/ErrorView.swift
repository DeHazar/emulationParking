//
//  ErrorView.swift
//  parkingEmulator
//
//  Created by Denchik on 07.05.2020.
//  Copyright © 2020 UGATU. All rights reserved.
//

import SwiftUI

struct ErrorView: View {
    var str: String
    var body: some View {
        Text(str)
    }
}

struct ErrorView_Previews: PreviewProvider {
    static var previews: some View {
        ErrorView(str: "")
    }
}
