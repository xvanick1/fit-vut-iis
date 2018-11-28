import { Injectable } from '@angular/core';
import {AuthService} from "./auth.service";
import * as moment from 'moment';
import { Router } from "@angular/router";

@Injectable({
  providedIn: 'root'
})
export class AutoLogoutService {

  constructor(private router: Router) {
    console.log('auto-logout');
    this.resetTime();
    this.clickListener();
    this.checkInterval();
  }

  resetTime() {
    const timeNow = moment();
    localStorage.setItem('lastAction', timeNow.toISOString());
  }

  clickListener() {
    document.body.addEventListener('click', () => {
      this.resetTime();
    })
  }

  checkInterval() {
    setInterval(() => {
      const timeNow = moment().subtract(10,'minutes');
      const lastTime = moment(localStorage.getItem('lastAction'));
      if ((timeNow > lastTime && AuthService.isLoggedIn()) || AuthService === undefined || AuthService.isLoggedIn() === undefined) {
        AuthService.logout();
        this.router.navigate(['/login'], {queryParams: { returnUrl: this.router.url }});
      }
    }, 5000);
  }
}
