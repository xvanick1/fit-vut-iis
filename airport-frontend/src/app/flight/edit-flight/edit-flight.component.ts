import { Component, OnInit } from '@angular/core';
import {ApiFlight, Flight, formFlight} from "../../_model/flight";
import {Airplane} from "../../_model/airplane";
import {Terminal} from "../../_model/terminal";
import {Gate} from "../../_model/gate";
import {FlightService} from "../../_service/flight.service";
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-edit-flight',
  templateUrl: '../form-flight.component.html',
  styleUrls: ['../form-flight.component.scss']
})
export class EditFlightComponent implements OnInit {
  title: string = 'Upravit let';
  flight: formFlight;
  apiFlight: ApiFlight;
  submitted: boolean = false;
  airplanes: Airplane[];
  terminals: Terminal[];
  gates: Gate[];

  constructor(
    private flightService: FlightService,
    private route: ActivatedRoute
  ) { }

  ngOnInit() {
    this.flight = new formFlight();
    this.route.params.subscribe(params => {
      this.flight.id = +params['id']; // (+) converts string 'id' to a number
      // In a real app: dispatch action to load the details here.
    });

    this.flightService.getFlight(this.flight.id).subscribe(resp => {
      if (resp.status == 200) {
        this.apiFlight = resp.body;
        this.flight.id = this.apiFlight.id;
        this.flight.destination = this.apiFlight.destination;
      } else {
        //redirect
      }
    });

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
