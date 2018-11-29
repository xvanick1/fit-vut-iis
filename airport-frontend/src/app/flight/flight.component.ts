import {Component, OnInit } from '@angular/core';
import { Flight } from '../_model/flight';
import { FlightService } from '../_service/flight.service';
import {FormControl, FormGroup, Validators} from '@angular/forms';
import * as moment from 'moment';
import {DatePipe} from "@angular/common";

@Component({
  selector: 'app-flight',
  templateUrl: './flight.component.html',
  styleUrls: ['./flight.component.scss']
})


export class FlightComponent implements OnInit {
  myForm: FormGroup;
  flights: Flight[];

  constructor(
    private flightService: FlightService,
    private datepipe: DatePipe
  ) {}

  ngOnInit() {
    this.myForm = new FormGroup({
      'dateInput': new FormControl(),
      'timeInput': new FormControl(),
      'flightInput': new FormControl('', [
        Validators.pattern('[1-9][0-9]*')
        ]),
      'terminalInput': new FormControl('', [
        Validators.maxLength(190),
        Validators.pattern('^\\S.*$')
      ]),
      'gateInput': new FormControl('', [
        Validators.maxLength(190),
        Validators.pattern('^\\S.*$')
      ]),
      'destinationInput': new FormControl('', [
        Validators.maxLength(190),
        Validators.pattern('^\\S.*$')
      ])
    });

    //this.myForm.get('dateInput').setValue(this.datepipe.transform(new Date(), 'yyyy-MM-dd'));

    this.onChanges();
    this.getFlights();
  }

  onChanges(): void {
    this.myForm.valueChanges.subscribe(value => {
      this.getFlights();
    });
  }

  getFlights(): void {
    let params = new Map();
    if (!this.myForm.valid) {
      return;
    }

    params.set('date', this.myForm.get('dateInput').value);
    params.set('time', this.myForm.get('timeInput').value);
    params.set('flight', this.myForm.get('flightInput').value);
    params.set('gate', this.myForm.get('gateInput').value);
    params.set('terminal', this.myForm.get('terminalInput').value);
    params.set('destination', this.myForm.get('destinationInput').value);

    this.flights = [];
    this.flightService.getFlights(params).subscribe(flights => {
      this.flights = [];
      for (let apiFlight of flights) {
        let flight = new Flight();
        flight.terminal = apiFlight.terminal;
        flight.gate = apiFlight.gate;
        flight.destination = apiFlight.destination;
        flight.id = apiFlight.id;
        let time = moment(apiFlight.timeOfDeparture.date);
        flight.time = {hours: time.hours(), minutes: time.minutes()};
        this.flights.push(flight);
      }
    });
  }

  cancelFlight(flight: Flight): void {

  }
}
