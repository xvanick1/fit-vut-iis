import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppComponent } from './app.component';

import { HTTP_INTERCEPTORS, HttpClientModule} from '@angular/common/http';
import { FormsModule, ReactiveFormsModule} from '@angular/forms';
import { AppRoutingModule } from './app-routing.module';
import { BasicAuthInterceptor } from './_helper/basic-auth.interceptor';

import { HeaderComponent } from './header/header.component';
import { TicketComponent } from './ticket/ticket.component';

import { FlightComponent } from './flight/flight.component';
import { TerminalComponent } from './terminal/terminal.component';
import { AirplaneTypeComponent } from './airplane-type/airplane-type.component';
import { AirplaneComponent } from './airplane/airplane.component';
import { LoginComponent } from './login/login.component';
import {DatePipe, DecimalPipe} from '@angular/common';
import { CreateFlightComponent } from './flight/create-flight/create-flight.component';
import { NotFoundComponent } from './not-found/not-found.component';
import { DateValidatorDirective } from './_helper/date-validator.directive';
import { TimeValidatorDirective } from './_helper/time-validator.directive';
import { EditFlightComponent } from './flight/edit-flight/edit-flight.component';
import { UserComponent } from './user/user.component';
import { CreateUserComponent } from './user/create-user/create-user.component';
import { EditUserComponent } from './user/edit-user/edit-user.component';
import { EditTerminalComponent } from './terminal/edit-terminal/edit-terminal.component';
import { CreateTerminalComponent } from './terminal/create-terminal/create-terminal.component';
import { EditAirplaneTypeComponent } from './airplane-type/edit-airplane-type/edit-airplane-type.component';
import { CreateAirplaneTypeComponent } from './airplane-type/create-airplane-type/create-airplane-type.component';
import { AirplaneClassComponent } from './airplane-class/airplane-class.component';
import { EditAirplaneComponent } from './airplane/edit-airplane/edit-airplane.component';
import { CreateAirplaneComponent } from './airplane/create-airplane/create-airplane.component';

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
    TimeValidatorDirective,
    EditFlightComponent,
    UserComponent,
    CreateUserComponent,
    EditUserComponent,
    EditTerminalComponent,
    CreateTerminalComponent,
    EditAirplaneTypeComponent,
    CreateAirplaneTypeComponent,
    AirplaneClassComponent,
    EditAirplaneComponent,
    CreateAirplaneComponent,
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
    DecimalPipe,
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
