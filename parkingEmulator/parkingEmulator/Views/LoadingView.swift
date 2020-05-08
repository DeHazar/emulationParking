//
//  LoadingView.swift
//  parkingEmulator
//
//  Created by Denchik on 07.05.2020.
//  Copyright © 2020 UGATU. All rights reserved.
//

import SwiftUI
struct LoadingView: View {
    @State private var animateTrimmedCicle = false
    @State private var animateInnerCicle = false
    var body: some View {
        ZStack {
            Color(#colorLiteral(red: 1, green: 1, blue: 1, alpha: 1))
                .edgesIgnoringSafeArea(.all)
            Circle()
                .frame(width: 30, height: 30)
                .foregroundColor(Color(#colorLiteral(red: 0, green: 0.5898008943, blue: 1, alpha: 1)))
                .scaleEffect(animateInnerCicle ? 1 : 0.5)
                .animation(Animation.interpolatingSpring(stiffness: 170, damping: 20).speed(1.5).repeatForever(autoreverses: true))
                 .onAppear() {
                    self.animateInnerCicle.toggle()
            }
            ZStack {
                Circle()
                    .trim(from: 3/4, to: 1)
                    .stroke(style: StrokeStyle(lineWidth: 3, lineCap: .round, lineJoin: .round))
                    .frame(width: 50, height: 50)
                    .foregroundColor(Color(#colorLiteral(red: 0, green: 0.5898008943, blue: 1, alpha: 1)))
                Circle()
                    .trim(from: 3/4, to: 1)
                    .stroke(style: StrokeStyle(lineWidth: 3, lineCap: .round, lineJoin: .round))
                    .frame(width: 50, height: 50)
                    .foregroundColor(Color(#colorLiteral(red: 0, green: 0.5898008943, blue: 1, alpha: 1)))
                    .rotationEffect(.degrees(-180))
            }.scaleEffect(animateTrimmedCicle ? 1 : 0.4 )
                .rotationEffect(.degrees(animateTrimmedCicle ? 360 : 0))
                .animation(Animation.interpolatingSpring(stiffness: 170, damping: 20).speed(1.5).repeatForever(autoreverses: true))
                 .onAppear() {
                self.animateTrimmedCicle.toggle()
            }
        }
    }
}

struct LoadingView_Previews: PreviewProvider {
    static var previews: some View {
        LoadingView()
    }
}
