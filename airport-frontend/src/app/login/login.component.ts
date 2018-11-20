import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { AuthService } from "../_service/auth.service";
import { User } from "../_model/user";

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {
  returnUrl: String;
  submitted: Boolean = false;
  authFailed: Boolean = false;
  user = new User();

  constructor(
    private router: Router,
    private route: ActivatedRoute,
    private authService: AuthService
  ) { }

  ngOnInit() {
    AuthService.logout();
    this.returnUrl = this.route.snapshot.queryParams['returnUrl'] || '/';
  }

  onSubmit() {
    this.submitted = true;
    this.authFailed = false;
    this.authService.login(this.user.username, this.user.password).subscribe(
      resp => {
        if (resp.status == 200) {
          AuthService.setBasiAuth(this.user.username, this.user.password);
          this.router.navigate([this.returnUrl]);
        } else {
          this.submitted = false;
          this.authFailed = true;
        }
      },
      error1 => {
        this.submitted = false;
        this.authFailed = true;
      });
  }
}
