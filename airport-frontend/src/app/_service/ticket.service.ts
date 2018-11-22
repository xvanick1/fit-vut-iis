import { Injectable } from '@angular/core';
import { environment} from "../../environments/environment";
import { HttpClient} from "@angular/common/http";
import { Observable} from "rxjs";
import { Ticket } from "../_model/ticket";

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
}
