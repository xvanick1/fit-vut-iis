import { Injectable } from '@angular/core';
import { Observable } from "rxjs";
import { HttpClient }    from '@angular/common/http';

import { Flight } from "../_model/flight";

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
