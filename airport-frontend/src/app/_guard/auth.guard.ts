import { Injectable } from '@angular/core';
import { Router, CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';

@Injectable({
  providedIn: 'root'
})
export class AuthGuard implements CanActivate {

  constructor(private router: Router){}

  canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot) {
    if (!localStorage.getItem('loggedUser')) {
      this.router.navigate(['/login'], {queryParams: { returnUrl: state.url }});
      return false;
    }

    let expectedRoleArray = route.data.expectedRole;
    let userRole = atob(localStorage.getItem('role'));

    for(let i = 0; i < expectedRoleArray.length; i++){
      if(expectedRoleArray[i] == userRole){
        console.log("Roles OK");
        return true;
      }
    }

    return false;
  }
}
