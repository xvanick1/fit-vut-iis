import { Injectable } from '@angular/core';
import { Observable } from "rxjs";
import { HttpClient }    from '@angular/common/http';
import * as moment from 'moment';
import { Flight } from "../_model/flight";
import {forEach} from "@angular/router/src/utils/collection";

@Injectable({
  providedIn: 'root'
})

export class FlightService {
  private flightsURL = 'http://localhost:8000/api/flights'; // URL to API flights

  constructor(private http: HttpClient) { }

  getFlights(params: Map<string, string>): Observable<Flight[]> {
    let urlParams: String = '?';
    if (params) {
      params.forEach(((value, key) => {
        if (value != undefined && value != '') {
          switch (key) {
            case 'date':
              urlParams += 'departureDate='+value;
              break;
            case 'time':
              urlParams += 'departureTime='+value;
              break;
            case 'flight':
              urlParams += 'flightID='+value;
              break;
            default:
              urlParams += key+'='+value;
              break;
          }
          urlParams += '&';
        }
      }));
    }
    return this.http.get<Flight[]>(this.flightsURL+urlParams);
  }
}
