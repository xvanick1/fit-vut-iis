import {Component, Input, OnInit, SimpleChanges} from '@angular/core';
import { Flight } from "../_model/flight";
import { FlightService } from "../_service/flight.service";
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
  /*
  dateInput: FormControl;
  flightInput: FormControl;
  terminalInput: FormControl;
  gateInput: FormControl;
  destinationInput: FormControl;
  timeInput: FormControl;
  */

  constructor(
    private flightService: FlightService,
    private datepipe: DatePipe
  ) {}

  ngOnInit() {
    this.myForm = new FormGroup({
      'dateInput': new FormControl('', [
          Validators.pattern('([12]\\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\\d|3[01]))')
        ]),
      'timeInput': new FormControl('', [
         Validators.pattern('(([01][0-9])|(2[0-3])):[0-5][0-9]')
        ]),
      'flightInput': new FormControl('', [
          Validators.pattern('[1-9][0-9]*')
        ]),
      'terminalInput': new FormControl(),
      'gateInput': new FormControl(),
      'destinationInput': new FormControl()
    });

    this.myForm.get('dateInput').setValue(this.datepipe.transform(new Date(), 'yyyy-MM-dd'));

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

    this.flights = null;
    this.flightService.getFlights(params).subscribe(flights => {
      this.flights = flights;
      for (let flight of this.flights) {
        let time = moment(flight.timeOfDeparture);//object .date
        flight.timeOfDeparture.hours = <number>time.hour();
        flight.timeOfDeparture.minutes = time.minutes();
      }
    });
  }

  cancelFlight(flight: Flight): void {

  }
}
