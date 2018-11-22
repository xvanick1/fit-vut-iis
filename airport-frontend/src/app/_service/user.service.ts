import { Injectable } from '@angular/core';
import {environment} from "../../environments/environment";
import {HttpClient} from "@angular/common/http";
import {Observable} from "rxjs";
import { Role, User } from "../_model/user";

@Injectable({
  providedIn: 'root'
})
export class UserService {
  private usersURL = environment.apiUrl+'/api/users'; // URL to API tickets

  constructor(private http: HttpClient) { }

  getRoleName(role: string): string {
    switch (role) {
      case 'ROLE_ADMIN':
        return 'Administrátor';
      case 'ROLE_USER':
        return 'Pracovník';
      case 'ROLE_MANAGER':
        return 'Manažer';
      default:
        return null;
    }
  }

  getUsers(): Observable<User[]> {
    return this.http.get<User[]>(this.usersURL);
  }

  getUser(id: number): Observable<any> {
    return this.http.get<User>(this.usersURL+'/'+id, {observe: 'response'});
  }

  getRoles() {
    return this.http.get<Role[]>(this.usersURL+'/roles', {observe: 'response'});
  }

  setUserStatus(id: number, status: boolean): Observable<any> {
    return this.http.patch(this.usersURL+'/'+id, {'isActive': status});
  }

  updateUser(user: User): Observable<any> {
    return this.http.patch(this.usersURL+'/'+user.id, user);
  }

  deleteUser(id: number): Observable<any> {
    return this.http.delete(this.usersURL+'/'+id);
  }

  createUser(user: User): Observable<any> {
    return this.http.post(this.usersURL, user);
  }
}
