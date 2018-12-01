import { Component, OnInit } from '@angular/core';
import {FormControl, FormGroup, Validators} from "@angular/forms";
import {Message} from "../../_model/message";
import {AirplaneType} from "../../_model/airplane-type";
import {AirTypeGate, Gate} from "../../_model/gate";
import {Terminal} from "../../_model/terminal";
import {AirplaneTypeService} from "../../_service/airplane-type.service";
import {TerminalService} from "../../_service/terminal.service";
import {ActivatedRoute, Router} from "@angular/router";
import * as modal from "../../_helper/modal";

@Component({
  selector: 'app-create-airplane-type',
  templateUrl: '../form-airplane-type.component.html',
  styleUrls: ['../form-airplane-type.component.scss']
})
export class CreateAirplaneTypeComponent implements OnInit {
  seatForm: FormGroup;
  title = 'Vytvořit typ letadla';
  submitted: boolean = false;
  isLoading: boolean = false;
  created: boolean = false;
  message: Message;
  airplaneType: AirplaneType;
  tmpGate: AirTypeGate;
  terminals: Terminal[];
  gates: Gate[];
  apiGates: Gate[];

  constructor(
    private airplaneTypeService: AirplaneTypeService,
    private terminalService: TerminalService,
    private router: Router,
    private route: ActivatedRoute
  ) { }

  ngOnInit() {
    this.terminals = [];

    this.seatForm = new FormGroup({
      'gateNameInput': new FormControl('', [
        Validators.required
      ]),
      'terminalNameInput': new FormControl('', [
        Validators.required
      ])
    });

    this.airplaneType = new AirplaneType();
    this.airplaneType.gates = [];
    this.airplaneType.deletedGates = [];

    this.onChanges();

    this.airplaneTypeService.getGates().subscribe( resp => {
      this.apiGates = resp;
      for (let gate of this.apiGates) {
        if (!this.terminals.some(t => t.id === gate.terminal.id)) {
          this.terminals.push(gate.terminal);
        }
      }
    });
  }

  deleteGate(gate: AirTypeGate) {
    if (gate.id) {
      this.airplaneType.deletedGates.push(gate);
    }
    let gates: AirTypeGate[] = [];
    for(let tmp of this.airplaneType.gates) {
      if (tmp !== gate) {
        gates.push(tmp);
      }
    }
    this.airplaneType.gates = gates;
  }

  addGate(id: string) {
    modal.openModal(id);
    this.tmpGate = new AirTypeGate();
  }

  saveButton(id: string) {
    modal.closeModal(id);
    for (let gate of this.apiGates) {
      if (gate.id == this.seatForm.get('gateNameInput').value) {
        this.tmpGate.id = gate.id;
        this.tmpGate.name = gate.name;
        this.tmpGate.terminalName = gate.terminal.name;
        if (!this.airplaneType.gates.some(g => g.id === gate.id)) {
          this.airplaneType.gates.push(this.tmpGate);
        }
      }
    }
    this.seatForm.get('gateNameInput').setValue('');
    this.seatForm.get('terminalNameInput').setValue('');
  }

  closeModal(id: string) {
    modal.closeModal(id);
  }

  onChanges(): void {
    this.seatForm.get('terminalNameInput').valueChanges.subscribe(value => {
      this.gates = [];
      for (let gate of this.apiGates) {
        if (gate.terminal.id == value) {
          this.gates.push(gate);
        }
      }
    });
  }

  onSubmit() {
    if (this.created) {
      this.router.navigate(['typyLetadel/vytvorit']);
      return;
    }

    this.submitted = true;
    this.message = null;
    this.airplaneTypeService.createAirplaneType(this.airplaneType).subscribe(resp => {
      this.message = new Message();
      this.message.type = 'success';
      this.message.text = 'Typ letadla byl úspěšně vytvořen';
      this.submitted = false;
      this.created = true;
    }, error1 => {
      this.message = new Message();
      this.message.type = 'alert';
      this.message.text = 'Při vytváření typu letadla nastala chyba';
      this.submitted = false;
    });
  }

}
