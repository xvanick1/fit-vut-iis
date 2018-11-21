import { Injectable } from '@angular/core';
import {HttpClient, HttpHeaders} from "@angular/common/http";

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  static loggedIn: Boolean;

  constructor(private http: HttpClient) {
    AuthService.loggedIn = false;
  }

  login(username: string, password: string) {
    return this.http.get<any>('http://localhost:8000/api/flights', {
      observe: 'response',
      headers: new HttpHeaders().set('Authorization', 'Basic '+window.btoa(username + ':' + password)),
    });
  }

  static setBasiAuth(username: string, password: string) {
    localStorage.setItem('loggedUser', window.btoa(username + ':' + password));
    AuthService.loggedIn = true;
  }

  static logout() {
    localStorage.removeItem('loggedUser')
    AuthService.loggedIn = false;
  }
}
