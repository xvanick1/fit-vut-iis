import { Injectable } from '@angular/core';
import {HttpClient, HttpHeaders} from "@angular/common/http";
import {catchError, tap} from "rxjs/operators";
import {Observable} from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  success: Boolean;

  constructor(private http: HttpClient) {
    this.success = true;
  }

  login(username: string, password: string) {
    return this.http.get<any>('http://localhost:8000/api/flights', {
      observe: 'response',
      headers: new HttpHeaders().set('Authorization', 'Basic '+window.btoa(username + ':' + password)),
    });

    /*
    .subscribe(resp => {
      if (resp.status !== 200) {
        this.success = false;
      }
    });

    if (this.success) {
      localStorage.setItem('loggedUser', window.btoa(username + ':' + password));
    }

    return this.success;
    */
  }

  static setBasiAuth(username: string, password: string) {
    localStorage.setItem('loggedUser', window.btoa(username + ':' + password));
  }

  static logout() {
    localStorage.removeItem('loggedUser')
  }
}
