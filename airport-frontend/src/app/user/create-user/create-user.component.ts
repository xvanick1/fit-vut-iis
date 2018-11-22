import { Component, OnInit } from '@angular/core';
import {Role, User} from "../../_model/user";
import {UserService} from "../../_service/user.service";
import {Message} from "../../_model/message";
import {Router} from "@angular/router";

@Component({
  selector: 'app-create-user',
  templateUrl: '../form-user.component.html',
  styleUrls: ['../form-user.component.scss']
})
export class CreateUserComponent implements OnInit {
  title = 'Vytvořit uživatele';
  submitted: boolean = false;
  isLoading: boolean = false;
  created: boolean = false;
  message: Message;
  user: User;
  roles: Role[];

  constructor(
    private userService: UserService,
    private router: Router
  ) { }

  ngOnInit() {
    this.user = new User();
    this.user.isActive = false;
    this.userService.getRoles().subscribe(resp => this.roles = resp.body);
  }

  getRoleName(role: string): string {
    return this.userService.getRoleName(role);
  }

  onSubmit() {
    if (this.created) {
      this.router.navigate(['uzivatele/vytvorit']);
      return;
    }

    this.submitted = true;
    this.message = null;
    this.userService.createUser(this.user).subscribe(resp => {
      this.message = new Message();
      this.message.type = 'success';
      this.message.text = 'Uživatel byl úspěšně vytvořen';
      this.submitted = false;
      this.created = true;
    }, error1 => {
      this.message = new Message();
      this.message.type = 'alert';
      this.message.text = 'Při vytváření uživatele nastala chyba';
      this.submitted = false;
    });
  }
}
