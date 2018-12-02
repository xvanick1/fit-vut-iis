import { Flight } from "../_model/flight";
import {Airplane} from "../_model/airplane";
import {Terminal} from "../_model/terminal";
import {Gate} from "../_model/gate";
import {FlightService} from "../_service/flight.service";
import {ActivatedRoute, Router} from "@angular/router";
import * as moment from "moment";
import {Time} from "@angular/common";
import {AirplaneService} from "../_service/airplane.service";
import {FormControl, Validators} from "@angular/forms";
import {AirplaneType} from "../_model/airplane-type";
import {Message} from "../_model/message";

export class FormFlightComponent {
  title: string;
  flight: Flight;
  isLoading: boolean = true;
  submitted: boolean = false;
  created: boolean = false;
  message: Message;
  airplaneInput: FormControl;
  gateInput: FormControl;
  airplanes: Airplane[];
  terminals: Terminal[];
  gates: Gate[];

  constructor(
    protected flightService: FlightService,
    protected airplaneService: AirplaneService,
    protected route: ActivatedRoute,
    protected router: Router
  ) {
    this.flight = new Flight();
    this.airplanes = [];
    this.terminals = [];
    this.gates = [];

    this.gateInput = new FormControl('', [
      Validators.required,
      Validators.pattern('[1-9][0-9]*')
    ]);
    this.airplaneInput = new FormControl('', [
      Validators.required,
      Validators.pattern('[1-9][0-9]*')
    ]);
    this.gateInput.disable();
  }

  extractTime(time: string): Time {
    const [h, m] = time.split(':');
    return {hours: +h, minutes: +m};
  }

  changeDepartureDate(value: any){
    if (!value.valid) {
      return;
    }
    this.flight._dateOfDeparture = moment(value.value).toDate();
  }

  changeTimeOfDeparture(value: any){
    if (!value.valid) {
      return;
    }
    this.flight._timeOfDeparture = this.extractTime(value.value);
  }

  changeFlightLength(value: any){
    if (!value.valid) {
      return;
    }
    this.flight._flightLength = this.extractTime(value.value);
  }

  changeAirplane() {
    this.gateInput.disable();
    this.flight.airplane.id = parseInt(this.airplaneInput.value);
    this.getGates();
  }

  changeGate() {
    this.flight.gate.id = parseInt(this.gateInput.value);
  }

  getAirplanes() {
    this.airplaneService.getAirplanes().subscribe(airplanes => {
      this.isLoading = false;
      this.airplanes = airplanes;
      this.getGates();
      this.gateInput.reset();
    });
  }

  getGates() {
    let airplaneType: AirplaneType;
    for (let tmpAirplane of this.airplanes) {
      if (tmpAirplane.id === this.flight.airplane.id) {
        airplaneType = tmpAirplane.type;
        break;
      }
    }
    console.log(this.flight);
    console.log(airplaneType);
    if (!airplaneType) {
      return;
    }
    this.flightService.getGatesByAirplaneType(airplaneType.id).subscribe(resp => {
      this.gates = resp;
      if (this.gates.length > 0) {
        this.gateInput.enable();
        let gate = this.gates.pop();
        this.gates.push(gate);
        if (!this.flight.id) {
          this.gateInput.setValue(gate.id);
        } else {
          this.gateInput.setValue(this.flight.gate.id);
        }
      }
    });
  }

}
