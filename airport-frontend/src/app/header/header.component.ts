import { Component, OnInit } from '@angular/core';
import { Router } from "@angular/router";
import {AutoLogoutService} from "../_service/auto-logout.service";
import {AuthService} from "../_service/auth.service";

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss']
})


export class HeaderComponent implements OnInit {
  public autoLogout: AutoLogoutService;

  constructor(public router: Router) { }

  ngOnInit() {
    this.autoLogout = new AutoLogoutService(this.router);
  }

  logout() {
    AuthService.logout();
    this.router.navigate(['/login']);
  }

  isRole(role: string): boolean {
    if (!AuthService.loggedIn) {
      return false;
    }
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
