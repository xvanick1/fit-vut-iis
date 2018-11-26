import { Component, OnInit } from '@angular/core';
import {ActivatedRoute, Router} from "@angular/router";
import {Message} from "../../_model/message";
import {Terminal} from "../../_model/terminal";
import {TerminalService} from "../../_service/terminal.service";
import {Gate} from "../../_model/gate";
import {FormControl, Validators} from "@angular/forms";
import * as modal from '../../_helper/modal';

@Component({
  selector: 'app-edit-terminal',
  templateUrl: '../form-terminal.component.html',
  styleUrls: ['../form-terminal.component.scss']
})
export class EditTerminalComponent implements OnInit {
  gateName: FormControl;
  gateButton: FormControl;
  tmpGate: Gate;
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
    this.gateName = new FormControl('', [
      Validators.required
    ]);
    this.gateButton = new FormControl();

    this.terminal = new Terminal();
    this.route.params.subscribe(params => {
      this.terminal.id = +params['id'];
      // In a real app: dispatch action to load the details here.
    });

    this.terminalService.getTerminal(this.terminal.id).subscribe(resp => {
        this.terminal = resp.body;
        this.terminal.deletedGates = [];
        this.isLoading = false;
      },
      error1 => {
        this.router.navigate(['404']);
      });
  }

  onSubmit() {
    this.submitted = true;
    this.message = null;
    this.terminalService.updateTerminal(this.terminal).subscribe(resp => {
      this.message = new Message();
      this.message.type = 'success';
      this.message.text = 'Terminál byl úspěšně uložen';
      this.submitted = false;
    }, error1 => {
      this.message = new Message();
      this.message.type = 'alert';
      this.message.text = 'Při ukládání terminálu nastala chyba';
      for (let gate of this.terminal.deletedGates) {
        this.terminal.gates.push(gate);
      }
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

  deleteGate(gate: Gate) {
    if (gate.id) {
      this.terminal.deletedGates.push(gate);
    }
    let gates: Gate[] = [];
    for(let tmp of this.terminal.gates) {
      if (tmp !== gate) {
        gates.push(tmp);
      }
    }
    this.terminal.gates = gates;
  }

  createGate(id: string) {
    modal.openModal(id);
    this.gateName.setValue('');
    this.tmpGate = new Gate();
  }

  saveButon(id: string) {
    if (!this.tmpGate.id) {
      let newGate = new Gate();
      newGate.name = this.gateName.value;
      this.terminal.gates.push(newGate);
    } else {
      this.tmpGate.name = this.gateName.value;
    }
    modal.closeModal(id);
  }

  updateGate(id: string, gate: Gate) {
    modal.openModal(id);
    this.gateName.setValue(gate.name);
    this.tmpGate = gate;
  }

  closeModal(id: string) {
    modal.closeModal(id);
  }
}
