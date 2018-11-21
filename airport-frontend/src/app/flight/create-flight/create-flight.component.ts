import { Component, OnInit } from '@angular/core';
import {formFlight} from "../../_model/flight";
import {Gate} from "../../_model/gate";
import {Airplane} from "../../_model/airplane";
import {Terminal} from "../../_model/terminal";
import {FlightService} from "../../_service/flight.service";

@Component({
  selector: 'app-create-flight',
  templateUrl: './create-flight.component.html',
  styleUrls: ['./create-flight.component.scss']
})
export class CreateFlightComponent implements OnInit {
  flight: formFlight;
  submitted: boolean = false;
  airplanes: Airplane[];
  terminals: Terminal[];
  gates: Gate[];

  constructor(private flightService: FlightService) { }

  ngOnInit() {
    this.flight = new formFlight();
    this.airplanes = [];
    this.terminals = [];
    this.gates = [];
    this.getAirplanes();
  }

  onSubmit() {
    this.submitted = true;
  }

  getAirplanes() {

  }

  getTerminals() {

  }

  getGates() {

  }

}
