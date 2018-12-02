import { Injectable } from '@angular/core';
import { environment} from "../../environments/environment";
import { HttpClient} from "@angular/common/http";
import { Observable} from "rxjs";
import { Ticket } from "../_model/ticket";
import {Seat} from "../_model/seat";

@Injectable({
  providedIn: 'root'
})
export class TicketService {
  private ticketsURL = environment.apiUrl+'/api/tickets'; // URL to API tickets

  constructor(private http: HttpClient) { }

  getTickets(params: Map<string, string>): Observable<Ticket[]> {
    let urlParams: String = '?';
    if (params) {
      params.forEach(((value, key) => {
        if (value != undefined && value != '') {
          switch (key) {
            default:
              urlParams += key+'='+value;
              break;
          }
          urlParams += '&';
        }
      }));
    }
    return this.http.get<Ticket[]>(this.ticketsURL+urlParams);
  }

  getTicket(id: number): Observable<Ticket> {
    return this.http.get<Ticket>(this.ticketsURL+'/'+id);
  }

  getSeats(id: number): Observable<Seat[]> {
    return this.http.get<Seat[]>(this.ticketsURL+'/'+id+'/gates');
  }

  checkout(id: number, name: string, surname: string, seat: number): Observable<Ticket> {
    return this.http.patch<Ticket>(this.ticketsURL+'/'+id, {
      'name': name,
      'surname': surname,
      'seat': seat
    });
  }
}
