import { Injectable } from '@angular/core';
import { Observable, of } from "rxjs";
import { HttpClient, HttpHeaders }    from '@angular/common/http';

import { Flight } from "../flight/flight";

@Injectable({
  providedIn: 'root'
})

export class FlightService {
  private flightsURL = 'http://localhost:8000/api/flights'; // URL to API flights

  constructor(private http: HttpClient) { }

  getFlights(): Observable<Flight[]> {
    return this.http.get<Flight[]>(this.flightsURL);
  }
}
