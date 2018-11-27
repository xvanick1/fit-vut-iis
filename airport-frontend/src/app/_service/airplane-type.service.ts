import { Injectable } from '@angular/core';
import {environment} from "../../environments/environment";
import {HttpClient} from "@angular/common/http";
import {Observable} from "rxjs";
import {AirplaneType} from "../_model/airplane-type";
import {Gate} from "../_model/gate";

@Injectable({
  providedIn: 'root'
})
export class AirplaneTypeService {
  private airplaneTypesURL = environment.apiUrl+'/api/airplanes/types'; // URL to API tickets

  constructor(
    private http: HttpClient
  ) { }

  getAirplaneTypes(params: Map<string, string>): Observable<AirplaneType[]> {
    let urlParams: String = '?';
    if (params) {
      params.forEach(((value, key) => {
        if (value !== undefined && value !== '' && value !== null) {
          switch (key) {
            default:
              urlParams += key+'='+value;
              break;
          }
          urlParams += '&';
        }
      }));
    }
    return this.http.get<AirplaneType[]>(this.airplaneTypesURL+urlParams);
  }

  getAirplaneType(id: number): Observable<any> {
    return this.http.get<AirplaneType>(this.airplaneTypesURL+'/'+id, {observe: 'response'});
  }

  deleteAirplaneType(id: number): Observable<any> {
    return this.http.delete(this.airplaneTypesURL+'/'+id);
  }

  updateAirplaneType(airplaneType: AirplaneType): Observable<any> {
    return this.http.patch(this.airplaneTypesURL+'/'+airplaneType.id, airplaneType);
  }

  createAirplaneType(airplaneType: AirplaneType): Observable<any> {
    return this.http.post(this.airplaneTypesURL, airplaneType);
  }

  getGates(): Observable<Gate[]> {
    return this.http.get<Gate[]>(environment.apiUrl+'/api/gates');

  }
}
