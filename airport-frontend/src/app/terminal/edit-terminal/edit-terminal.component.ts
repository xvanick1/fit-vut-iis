import { Component, OnInit } from '@angular/core';
import {ActivatedRoute, Router} from "@angular/router";
import {Message} from "../../_model/message";
import {Terminal} from "../../_model/terminal";
import {TerminalService} from "../../_service/terminal.service";

@Component({
  selector: 'app-edit-terminal',
  templateUrl: '../form-terminal.component.html',
  styleUrls: ['../form-terminal.component.scss']
})
export class EditTerminalComponent implements OnInit {
  title = 'Upravit terminál';
  submitted: boolean = false;
  isLoading: boolean = true;
  created: boolean = false;
  message: Message;
  terminal: Terminal;

  constructor(
    private terminalService: TerminalService,
    private router: Router,
    private route: ActivatedRoute
  ) { }

  ngOnInit() {
    this.terminal = new Terminal();
    this.route.params.subscribe(params => {
      this.terminal.id = +params['id'];
      // In a real app: dispatch action to load the details here.
    });

    this.terminalService.getTerminal(this.terminal.id).subscribe(
      resp => {
        this.terminal = resp.body;
        this.isLoading = false;
      },
      error1 => {
        this.router.navigate(['404']);
      });
  }

  onSubmit() {
    this.submitted = true;
    this.message = null;
    this.terminalService.updateTerminal(this.terminal.id).subscribe(resp => {
      this.message = new Message();
      this.message.type = 'success';
      this.message.text = 'Terminál byl úspěšně uložen';
      this.submitted = false;
    }, error1 => {
      this.message = new Message();
      this.message.type = 'alert';
      this.message.text = 'Při ukládání terminálu nastala chyba';
      this.submitted = false;
    });
  }

  deleteTerminal() {
    this.submitted = true;
    this.message = null;
    this.terminalService.deleteTerminal(this.terminal.id).subscribe(resp => {
      this.router.navigate(['terminaly']);
    }, error1 => {
      this.message = new Message();
      this.message.type = 'alert';
      this.message.text = 'Při mazání terminálu nastala chyba';
      this.submitted = false;
    });
  }
}
