import { Component, OnInit } from '@angular/core';
import {AirplaneTypeService} from "../../_service/airplane-type.service";
import {ActivatedRoute, Router} from "@angular/router";
import {Message} from "../../_model/message";
import {AirplaneType} from "../../_model/airplane-type";
import {AirTypeGate, Gate} from "../../_model/gate";
import * as modal from "../../_helper/modal";
import {FormControl, Validators} from "@angular/forms";
import {Terminal} from "../../_model/terminal";
import {TerminalService} from "../../_service/terminal.service";


@Component({
  selector: 'app-edit-airplane-type',
  templateUrl: '../form-airplane-type.component.html',
  styleUrls: ['../form-airplane-type.component.scss']
})
export class EditAirplaneTypeComponent implements OnInit {
  gateNameInput: FormControl;
  terminalNameInput: FormControl;
  gateButton: FormControl;
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
    this.gateNameInput = new FormControl('', [
      Validators.required
    ]);
    this.terminalNameInput = new FormControl('', [
      Validators.required
    ]);

    this.airplaneType = new AirplaneType();
    this.route.params.subscribe(params => {
      this.airplaneType.id = +params['id']; //id should be name, right ?
      // In a real app: dispatch action to load the details here.
    });

    this.airplaneTypeService.getAirplaneType(this.airplaneType.id).subscribe(resp => { //id should be name, right ?
        this.airplaneType = resp.body;
        this.isLoading = false;
      },
      error1 => {
        this.router.navigate(['404']);
      });

    this.airplaneTypeService.getGates().subscribe( resp => {
      this.apiGates = resp;
      for (let gate of this.apiGates) {
        if (this.terminals.indexOf(gate.terminal) === -1) {
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
    this.tmpGate.name = this.gateNameInput.value;
    this.tmpGate.terminalName = this.terminalNameInput.value;
    this.airplaneType.gates.push(this.tmpGate);
  }

  closeModal(id: string) {
    modal.closeModal(id);
  }
}
