import { Injectable } from '@angular/core';
import {environment} from "../../environments/environment";
import {HttpClient} from "@angular/common/http";
import {Observable} from "rxjs";
import {AirplaneClass} from "../_model/airplane-class";

@Injectable({
  providedIn: 'root'
})
export class AirplaneClassService {
  private airplaneClassesURL = environment.apiUrl+'/api/airplanes/classes'; // URL to API tickets

  constructor(private http: HttpClient) { }

  getAirplaneClasses(params: Map<string, string>): Observable<AirplaneClass[]> {
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
    return this.http.get<AirplaneClass[]>(this.airplaneClassesURL+urlParams);
  }
}
