import { Component, OnInit } from '@angular/core';
import {Terminal} from '../_model/terminal';
import {FormControl, FormGroup, Validators} from "@angular/forms";
import {TerminalService} from '../_service/terminal.service';
import * as moment from 'moment';
import {User} from "../_model/user";

@Component({
  selector: 'app-terminal',
  templateUrl: './terminal.component.html',
  styleUrls: ['./terminal.component.scss']
})
export class TerminalComponent implements OnInit {
  myForm: FormGroup;
  terminals: Terminal[];

  constructor(
    private terminalService: TerminalService
  ) {
  }

  ngOnInit() {
    this.myForm = new FormGroup({
      'idInput': new FormControl('', [
        Validators.pattern('[1-9][0-9]*')
      ]),
      'nameInput': new FormControl(),
      'countOfGatesInput': new FormControl('', [
        Validators.pattern('[0-9][0-9]*')
      ])
    });

    this.onChanges();
    this.getTerminals();
  }

  onChanges(): void {
    this.myForm.valueChanges.subscribe(value => {
      this.getTerminals();
    });
  }

  getTerminals(): void {
    const params = new Map();
    if (!this.myForm.valid) {
      return;
    }

    params.set('id', this.myForm.get('idInput').value);
    params.set('name', this.myForm.get('nameInput').value);
    params.set('countOfGates', this.myForm.get('countOfGatesInput').value);


    this.terminals = [];
    this.terminalService.getTerminals(params).subscribe(terminals => {
      this.terminals = terminals;
    });
  }

  deleteTerminal(terminal: Terminal) {
    if (terminal._submitted) {
      return;
    }
    terminal._submitted = true;

    this.terminalService.deleteTerminal(terminal.id).subscribe(
      resp => {},
      error1 => {
        terminal._submitted = false;
      });
  }
}

