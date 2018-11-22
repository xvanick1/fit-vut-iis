import { Component, OnInit } from '@angular/core';
import {Role, User} from "../../_model/user";
import {UserService} from "../../_service/user.service";
import {ActivatedRoute, Router} from "@angular/router";
import {Message} from "../../_model/message";

@Component({
  selector: 'app-edit-user',
  templateUrl: '../form-user.component.html',
  styleUrls: ['../form-user.component.scss']
})
export class EditUserComponent implements OnInit {
  title = 'Upravit uživatele';
  submitted: boolean = false;
  isLoading: boolean = true;
  message: Message;
  user: User;
  roles: Role[];

  constructor(
    private userService: UserService,
    private router: Router,
    private route: ActivatedRoute
  ) { }

  ngOnInit() {
    this.user = new User();
    this.route.params.subscribe(params => {
      this.user.id = +params['id'];
      // In a real app: dispatch action to load the details here.
    });

    this.userService.getRoles().subscribe(resp => this.roles = resp.body);
    this.userService.getUser(this.user.id).subscribe(
      resp => {
        this.user = resp.body;
        this.isLoading = false;
      },
      error1 => {
        this.router.navigate(['404']);
      });
  }

  getRoleName(role: string): string {
    return this.userService.getRoleName(role);
  }

  onSubmit() {
    this.submitted = true;
    this.message = null;
    this.userService.updateUser(this.user).subscribe(resp => {
      this.message = new Message();
      this.message.type = 'success';
      this.message.text = 'Uživatel byl úspěšně uložen';
      this.submitted = false;
    }, error1 => {
      this.message = new Message();
      this.message.type = 'alert';
      this.message.text = 'Při ukládání uživatele nastala chyba';
      this.submitted = false;
    });
  }
}
