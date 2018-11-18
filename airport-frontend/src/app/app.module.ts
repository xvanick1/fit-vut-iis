import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppComponent } from './app.component';

import {HttpClientModule} from "@angular/common/http";
import { AppRoutingModule } from './app-routing.module';

import { HeaderComponent } from './header/header.component';
import { TicketComponent } from './ticket/ticket.component';

import { FlightComponent } from './flight/flight.component';
import { TerminalComponent } from './terminal/terminal.component';
import { AirplaneTypeComponent } from './airplane-type/airplane-type.component';
import { AirplaneComponent } from './airplane/airplane.component';

@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    TicketComponent,
    FlightComponent,
    TerminalComponent,
    AirplaneTypeComponent,
    AirplaneComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
