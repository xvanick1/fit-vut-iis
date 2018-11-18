import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { TicketComponent } from './ticket/ticket.component';
import { FlightComponent } from './flight/flight.component';
import {TerminalComponent} from './terminal/terminal.component';
import {AirplaneTypeComponent} from './airplane-type/airplane-type.component';
import {AirplaneComponent} from './airplane/airplane.component';

const routes: Routes = [
  { path: '', redirectTo: '/letenky', pathMatch: 'full' },
  { path: 'letenky', component: TicketComponent },
  { path: 'lety', component: FlightComponent },
  { path: 'terminaly', component: TerminalComponent },
  { path: 'typyLetadel', component: AirplaneTypeComponent },
  { path: 'letadla', component: AirplaneComponent }
];

@NgModule({
  imports: [ RouterModule.forRoot(routes) ],
  exports: [ RouterModule ]
})
export class AppRoutingModule {}
