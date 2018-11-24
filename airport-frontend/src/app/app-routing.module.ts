import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AuthGuard } from "./_guard/auth.guard";
import { TicketComponent } from './ticket/ticket.component';
import { FlightComponent } from './flight/flight.component';
import { TerminalComponent } from './terminal/terminal.component';
import { AirplaneTypeComponent } from './airplane-type/airplane-type.component';
import { AirplaneComponent } from './airplane/airplane.component';
import { LoginComponent } from "./login/login.component";
import { CreateFlightComponent } from './flight/create-flight/create-flight.component';
import {NotFoundComponent} from "./not-found/not-found.component";
import {EditFlightComponent} from "./flight/edit-flight/edit-flight.component";
import {EditUserComponent} from "./user/edit-user/edit-user.component";
import {CreateUserComponent} from "./user/create-user/create-user.component";
import {UserComponent} from "./user/user.component";

const routes: Routes = [
  { path: '', redirectTo: '/letenky', pathMatch: 'full' },
  { path: 'letenky', component: TicketComponent, canActivate: [AuthGuard], data: { expectedRole: ['ROLE_USER','ROLE_MANAGER','ROLE_ADMIN'] } },
  { path: 'lety', component: FlightComponent, canActivate: [AuthGuard], data: { expectedRole: ['ROLE_MANAGER','ROLE_ADMIN'] } },
  { path: 'lety/vytvorit', component: CreateFlightComponent, canActivate: [AuthGuard], data: { expectedRole: ['ROLE_MANAGER','ROLE_ADMIN'] } },
  { path: 'lety/:id', component: EditFlightComponent, canActivate: [AuthGuard], data: { expectedRole: ['ROLE_MANAGER','ROLE_ADMIN'] } },

  { path: 'terminaly', component: TerminalComponent, canActivate: [AuthGuard], data: { expectedRole: ['ROLE_ADMIN'] } },
  { path: 'typyLetadel', component: AirplaneTypeComponent, canActivate: [AuthGuard], data: { expectedRole: ['ROLE_ADMIN'] } },
  { path: 'letadla', component: AirplaneComponent, canActivate: [AuthGuard], data: { expectedRole: ['ROLE_ADMIN'] } },

  { path: 'uzivatele', component: UserComponent, canActivate: [AuthGuard], data: { expectedRole: ['ROLE_ADMIN'] } },
  { path: 'uzivatele/vytvorit', component: CreateUserComponent, canActivate: [AuthGuard], data: { expectedRole: ['ROLE_ADMIN'] } },
  { path: 'uzivatele/:id', component: EditUserComponent, canActivate: [AuthGuard], data: { expectedRole: ['ROLE_ADMIN'] } },

  { path: 'login', component: LoginComponent },
  { path: '404', component: NotFoundComponent },
  { path: '**', component: NotFoundComponent }
];

@NgModule({
  imports: [ RouterModule.forRoot(routes) ],
  exports: [ RouterModule ]
})
export class AppRoutingModule {}
