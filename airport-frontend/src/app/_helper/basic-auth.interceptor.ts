import { Injectable } from '@angular/core';
import { HttpRequest, HttpHandler, HttpEvent, HttpInterceptor } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable()
export class BasicAuthInterceptor implements HttpInterceptor {
  intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    let loggedUser = localStorage.getItem('loggedUser');
    if (loggedUser) {
      request = request.clone({
        setHeaders: {
          Authorization: `Basic ${loggedUser}`
        }
      });
    }

    return next.handle(request);
  }
}
