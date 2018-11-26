import { Injectable } from '@angular/core';
import {Observable} from 'rxjs';
import {Airplane} from '../_model/airplane';
import {environment} from "../../environments/environment";
import {HttpClient} from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class AirplaneService {
  private airplanesURL = environment.apiUrl+'/api/airplanes'; // URL to API tickets

  constructor(private http: HttpClient) { }

  getAirplanes(): Observable<Airplane[]> {
    return this.http.get<Airplane[]>(this.airplanesURL);
  }

  getAirplane(id: number): Observable<any> {
    return this.http.get<Airplane>(this.airplanesURL+'/'+id, {observe: 'response'});
  }

  updateAirplane(airplane: Airplane): Observable<any> {
    return this.http.patch(this.airplanesURL+'/'+airplane.id, airplane);
  }

  deleteAirplane(id: number): Observable<any> {
    return this.http.delete(this.airplanesURL+'/'+id);
  }

  createAirplane(user: Airplane): Observable<any> {
    return this.http.post(this.airplanesURL, user);
  }
}
