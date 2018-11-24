import { Injectable } from '@angular/core';
import {environment} from "../../environments/environment";
import {HttpClient} from "@angular/common/http";
import {Observable} from "rxjs";
import {Terminal} from "../_model/terminal";
import {User} from "../_model/user";

@Injectable({
  providedIn: 'root'
})
export class TerminalService {
  private terminalsURL = environment.apiUrl+'/api/terminals'; // URL to API tickets

  constructor(
    private http: HttpClient
  ) { }

  getTerminals(params: Map<string, string>): Observable<Terminal[]> {
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
    return this.http.get<Terminal[]>(this.terminalsURL+urlParams);
  }

  getTerminal(id: number): Observable<any> {
    return this.http.get<Terminal>(this.terminalsURL+'/'+id, {observe: 'response'});
  }

  deleteTerminal(id: number): Observable<any> {
    return this.http.delete(this.terminalsURL+'/'+id);
  }

  updateTerminal(id: number): Observable<any> {
    return this.http.patch(this.terminalsURL+'/'+id, name);
  }

  createTerminal(id: number): Observable<any> {
    return this.http.post(this.terminalsURL, id);
  }
}
