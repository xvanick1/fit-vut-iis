import { Injectable } from '@angular/core';
import {HttpClient, HttpHeaders} from "@angular/common/http";
import {environment} from "../../environments/environment";

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  static loggedIn: Boolean;

  constructor(private http: HttpClient) {
    AuthService.loggedIn = false;
  }

  login(username: string, password: string) {
    return this.http.get<any>(environment.apiUrl+'/api/auth', {
      observe: 'response',
      headers: new HttpHeaders().set('Authorization', 'Basic '+window.btoa(username + ':' + password)),
    });
  }

  static setBasiAuth(username: string, password: string) {
    localStorage.setItem('loggedUser', window.btoa(username + ':' + password));
    AuthService.loggedIn = true;
  }

  static setRole(role: string) {
    localStorage.setItem('role', btoa(role));
  }

  static logout() {
    localStorage.removeItem('loggedUser')
    localStorage.removeItem('role')
    AuthService.loggedIn = false;
  }

  static hasRole(role: string): boolean {
    const currentRole = atob(localStorage.getItem('role'));
    if (currentRole == role) {
      return true;
    } else if (currentRole == 'ROLE_MANAGER' && role == 'ROLE_USER') {
      return true;
    } else if (currentRole == 'ROLE_ADMIN' && (role == 'ROLE_USER' || role == 'ROLE_MANAGER')) {
      return true;
    }

    return false;
  }
}
