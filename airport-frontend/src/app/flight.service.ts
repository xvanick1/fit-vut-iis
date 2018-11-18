import { Injectable } from '@angular/core';
import { Observable, of } from "rxjs";
import { HttpClient, HttpHeaders }    from '@angular/common/http';

import { Flight } from "./flight";

@Injectable({
  providedIn: 'root'
})

export class FlightService {
  private flightsURL = '/api/flights'; // URL to API flights

  constructor(private http: HttpClient) { }

  getFlights(): Observable<Flight[]> {
    return this.http.get<Flight[]>(this.flightsURL);
  }
}
