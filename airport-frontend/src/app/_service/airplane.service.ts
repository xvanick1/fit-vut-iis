import { Injectable } from '@angular/core';
import {Observable} from 'rxjs';
import {Airplane} from '../_model/airplane';
import {environment} from "../../environments/environment";
import {HttpClient} from '@angular/common/http';
import {DatePipe} from "@angular/common";

@Injectable({
  providedIn: 'root'
})
export class AirplaneService {
  private airplanesURL = environment.apiUrl+'/api/airplanes'; // URL to API tickets

  constructor(
    private http: HttpClient,
    private datepipe: DatePipe
  ) { }

  getAirplanes(): Observable<Airplane[]> {
    return this.http.get<Airplane[]>(this.airplanesURL);
  }

  getAirplane(id: number): Observable<any> {
    return this.http.get<Airplane>(this.airplanesURL+'/'+id, {observe: 'response'});
  }

  updateAirplane(airplane: Airplane): Observable<any> {
    return this.http.patch(this.airplanesURL+'/'+airplane.id, {
      'crewNumber': airplane.crewNumber,
      'dateOfProduction':this.datepipe.transform(airplane._dateOfProduction, 'yyyy-MM-dd'),
      'dateOfRevision': this.datepipe.transform(airplane._dateOfRevision, 'yyyy-MM-dd'),
      'type': airplane.type.id,
      'seats': airplane.seats,
      'updatedSeats': airplane.updatedSeats,
      'deletedSeats': airplane.deletedSeats,
    });
  }

  deleteAirplane(id: number): Observable<any> {
    return this.http.delete(this.airplanesURL+'/'+id);
  }

  createAirplane(airplane: Airplane): Observable<any> {
    return this.http.post(this.airplanesURL, {
      'crewNumber': airplane.crewNumber,
      'dateOfProduction':this.datepipe.transform(airplane._dateOfProduction, 'yyyy-MM-dd'),
      'dateOfRevision': this.datepipe.transform(airplane._dateOfRevision, 'yyyy-MM-dd'),
      'type': airplane.type.id,
      'seats': airplane.seats,
      'updatedSeats': airplane.updatedSeats,
      'deletedSeats': airplane.deletedSeats,
    });
  }
}
