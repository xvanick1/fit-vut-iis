import { Component, OnInit } from '@angular/core';
import {FormControl, Validators} from "@angular/forms";
import {Gate} from "../../_model/gate";
import {Message} from "../../_model/message";
import {Terminal} from "../../_model/terminal";
import {TerminalService} from "../../_service/terminal.service";
import {ActivatedRoute, Router} from "@angular/router";
import * as modal from "../../_helper/modal";

@Component({
  selector: 'app-create-terminal',
  templateUrl: '../form-terminal.component.html',
  styleUrls: ['../form-terminal.component.scss']
})
export class CreateTerminalComponent implements OnInit {
  gateName: FormControl;
  gateButton: FormControl;
  tmpGate: Gate;
  title = 'Vytvořit terminál';
  submitted: boolean = false;
  isLoading: boolean = false;
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
    this.terminal.gates = [];
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

  saveButton(id: string) {
    if (!this.tmpGate.id) {
      let newGate = new Gate();
      newGate.name = this.gateName.value;
      this.terminal.gates.push(newGate);
    } else {
      this.tmpGate.name = this.gateName.value;
      this.terminal.updatedGates.push(this.tmpGate);
    }
    modal.closeModal(id);
  }

  closeModal(id: string) {
    modal.closeModal(id);
  }

  onSubmit() {
    if (this.created) {
      this.router.navigate(['terminaly/vytvorit']);
      return;
    }

    this.submitted = true;
    this.message = null;
    this.terminalService.createTerminal(this.terminal).subscribe(resp => {
      this.message = new Message();
      this.message.type = 'success';
      this.message.text = 'Terminál byl úspěšně vytvořen';
      this.submitted = false;
      this.created = true;
    }, error1 => {
      this.message = new Message();
      this.message.type = 'alert';
      this.message.text = 'Při vytváření terminálu nastala chyba';
      this.submitted = false;
    });
  }
}
