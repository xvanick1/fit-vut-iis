import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppComponent } from './app.component';

import { HTTP_INTERCEPTORS, HttpClientModule} from "@angular/common/http";
import { FormsModule, ReactiveFormsModule} from '@angular/forms';
import { AppRoutingModule } from './app-routing.module';
import { BasicAuthInterceptor } from "./_helper/basic-auth.interceptor";

import { HeaderComponent } from './header/header.component';
import { TicketComponent } from './ticket/ticket.component';

import { FlightComponent } from './flight/flight.component';
import { TerminalComponent } from './terminal/terminal.component';
import { AirplaneTypeComponent } from './airplane-type/airplane-type.component';
import { AirplaneComponent } from './airplane/airplane.component';
import { LoginComponent } from './login/login.component';
import { DatePipe } from "@angular/common";
import { CreateFlightComponent } from './flight/create-flight/create-flight.component';
import { NotFoundComponent } from './not-found/not-found.component';
import { DateValidatorDirective } from './_helper/date-validator.directive';
import { TimeValidatorDirective } from './_helper/time-validator.directive';

@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    TicketComponent,
    FlightComponent,
    TerminalComponent,
    AirplaneTypeComponent,
    AirplaneComponent,
    LoginComponent,
    CreateFlightComponent,
    NotFoundComponent,
    DateValidatorDirective,
    TimeValidatorDirective
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    FormsModule,
    ReactiveFormsModule,
  ],
  providers: [
    { provide: HTTP_INTERCEPTORS, useClass: BasicAuthInterceptor, multi: true },
    DatePipe,
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
