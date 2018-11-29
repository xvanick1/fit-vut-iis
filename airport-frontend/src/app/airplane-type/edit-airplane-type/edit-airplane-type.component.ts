import { Component, OnInit } from '@angular/core';
import {AirplaneTypeService} from "../../_service/airplane-type.service";
import {ActivatedRoute, Router} from "@angular/router";
import {Message} from "../../_model/message";
import {AirplaneType} from "../../_model/airplane-type";
import {AirTypeGate, Gate} from "../../_model/gate";
import * as modal from "../../_helper/modal";
import {FormControl, FormGroup, Validators} from "@angular/forms";
import {Terminal} from "../../_model/terminal";
import {TerminalService} from "../../_service/terminal.service";


@Component({
  selector: 'app-edit-airplane-type',
  templateUrl: '../form-airplane-type.component.html',
  styleUrls: ['../form-airplane-type.component.scss']
})
export class EditAirplaneTypeComponent implements OnInit {
  myForm: FormGroup;
  title = 'Upravit typ letadla';
  submitted: boolean = false;
  isLoading: boolean = true;
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

    this.myForm = new FormGroup({
      'gateNameInput': new FormControl('', [
        Validators.required
      ]),
      'terminalNameInput': new FormControl('', [
        Validators.required
      ])
    });

    this.airplaneType = new AirplaneType();
    this.route.params.subscribe(params => {
      this.airplaneType.id = +params['id'];
      // In a real app: dispatch action to load the details here.
    });

    this.airplaneTypeService.getAirplaneType(this.airplaneType.id).subscribe(resp => {
        this.airplaneType = resp.body;
        this.airplaneType.deletedGates = [];
        this.isLoading = false;
      },
      error1 => {
        this.router.navigate(['404']);
      });

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

  onSubmit() {
    this.submitted = true;
    this.message = null;
    this.airplaneTypeService.updateAirplaneType(this.airplaneType).subscribe(resp => { //WTF error ?
      this.message = new Message();
      this.message.type = 'success';
      this.message.text = 'Typ letadla byl úspěšně uložen';
      this.submitted = false;
    }, error1 => {
      this.message = new Message();
      this.message.type = 'alert';
      this.message.text = 'Při ukládání typu letadla nastala chyba';
      this.submitted = false;
    });
  }

  deleteAirplaneType() {
    this.submitted = true;
    this.message = null;
    this.airplaneTypeService.deleteAirplaneType(this.airplaneType.id).subscribe(resp => {
      this.router.navigate(['typyLetadel']);
    }, error1 => {
      this.message = new Message();
      this.message.type = 'alert';
      this.message.text = 'Při mazání typu letadla nastala chyba';
      this.submitted = false;
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
      if (gate.id == this.myForm.get('gateNameInput').value) {
        this.tmpGate.id = gate.id;
        this.tmpGate.name = gate.name;
        this.tmpGate.terminalName = gate.terminal.name;
        if (!this.airplaneType.gates.some(g => g.id === gate.id)) {
          this.airplaneType.gates.push(this.tmpGate);
        }
      }
    }
    this.myForm.get('gateNameInput').setValue('');
    this.myForm.get('terminalNameInput').setValue('');
  }

  closeModal(id: string) {
    modal.closeModal(id);
  }

  onChanges(): void {
    this.myForm.get('terminalNameInput').valueChanges.subscribe(value => {
      this.gates = [];
      for (let gate of this.apiGates) {
        if (gate.terminal.id == value) {
          this.gates.push(gate);
        }
      }
    });
  }
}
