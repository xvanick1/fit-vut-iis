import { Component, OnInit } from '@angular/core';
import {Role, User} from "../../_model/user";
import {UserService} from "../../_service/user.service";

@Component({
  selector: 'app-create-user',
  templateUrl: '../form-user.component.html',
  styleUrls: ['../form-user.component.scss']
})
export class CreateUserComponent implements OnInit {
  title = 'Vytvořit uživatele';
  submitted: boolean = false;
  isLoading: boolean = false;
  hasMessage: boolean = false;
  user: User;
  roles: Role[];

  constructor(
    private userService: UserService
  ) { }

  ngOnInit() {
    this.user = new User();
    this.userService.getRoles().subscribe(resp => this.roles = resp.body);
  }

  getRoleName(role: string): string {
    return this.userService.getRoleName(role);
  }

}
