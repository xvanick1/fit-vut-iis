import { Component, OnInit } from '@angular/core';
import {User} from "../_model/user";
import {UserService} from "../_service/user.service";

@Component({
  selector: 'app-user',
  templateUrl: './user.component.html',
  styleUrls: ['./user.component.scss']
})
export class UserComponent implements OnInit {
  users: User[];

  constructor(
    private userService: UserService
  ) { }

  ngOnInit() {
    this.getUsers();
  }

  getUsers() {
    this.userService.getUsers().subscribe(users => {
      this.users = users;
    });
  }

  getRoleName(role: string): string {
    return this.userService.getRoleName(role);
  }

  deactivateUser(user: User) {
    if (user._submitted) {
      return;
    }
    user._submitted= true;

    this.userService.setUserStatus(user.id, !user.isActive).subscribe(
      resp => {
        user.isActive = false;
        user._submitted = false;
      });
  }

  activateUser(user: User) {
    if (user._submitted) {
      return;
    }
    user._submitted = true;

    this.userService.setUserStatus(user.id, !user.isActive).subscribe(
      resp => {
        user.isActive = true;
        user._submitted = false;
      });
  }
}
