import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { TicketComponent } from "./ticket/ticket.component";
import { FlightComponent } from "./flight/flight.component";

const routes: Routes = [
  { path: '', redirectTo: '/letenky', pathMatch: 'full' },
  { path: 'letenky', component: TicketComponent },
  { path: 'lety', component: FlightComponent }
];

@NgModule({
  imports: [ RouterModule.forRoot(routes) ],
  exports: [ RouterModule ]
})
export class AppRoutingModule {}
