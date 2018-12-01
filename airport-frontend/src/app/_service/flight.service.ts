import { Injectable } from '@angular/core';
import { Observable } from "rxjs";
import { HttpClient }    from '@angular/common/http';
import { Flight } from "../_model/flight";
import { environment } from '../../environments/environment';
import {Gate} from "../_model/gate";
import {DatePipe, DecimalPipe} from "@angular/common";

@Injectable({
  providedIn: 'root'
})

export class FlightService {
  private flightsURL = environment.apiUrl+'/api/flights'; // URL to API flights

  constructor(
    private http: HttpClient,
    private datepipe: DatePipe,
    private decimalpipe: DecimalPipe
  ) { }

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

  getFlight(id: number): Observable<any> {
    return this.http.get<Flight>(this.flightsURL+'/'+id, {observe: 'response'});
  }

  getGatesByAirplaneType(airplaneType: number){
    return this.http.get<Gate[]>(environment.apiUrl+'/api/gates/airplane/'+airplaneType);
  }

  createFlight(flight: Flight): Observable<any> {
    let time = this.decimalpipe.transform(flight._timeOfDeparture.hours, '2.0-0')+':'+this.decimalpipe.transform(flight._timeOfDeparture.minutes, '2.0-0');
    let length = this.decimalpipe.transform(flight._flightLength.hours, '2.0-0')+':'+this.decimalpipe.transform(flight._flightLength.minutes, '2.0-0');
    return this.http.post(this.flightsURL, {
      'destination': flight.destination,
      'dateOfDeparture':this.datepipe.transform(flight._dateOfDeparture, 'yyyy-MM-dd'),
      'gate': flight.gate.id,
      'airplane': flight.airplane.id,
      'timeOfDeparture': time,
      'flightLength': length
    });
  }

  updateFlight(flight: Flight): Observable<any> {
    let time = this.decimalpipe.transform(flight._timeOfDeparture.hours, '2.0-0')+':'+this.decimalpipe.transform(flight._timeOfDeparture.minutes, '2.0-0');
    let length = this.decimalpipe.transform(flight._flightLength.hours, '2.0-0')+':'+this.decimalpipe.transform(flight._flightLength.minutes, '2.0-0');
    return this.http.patch(this.flightsURL+'/'+flight.id, {
      'destination': flight.destination,
      'dateOfDeparture': this.datepipe.transform(flight._dateOfDeparture, 'yyyy-MM-dd'),
      'gate': flight.gate.id,
      'airplane': flight.airplane.id,
      'timeOfDeparture': time,
      'flightLength': length
    });
  }
}
