import { Component, OnInit } from '@angular/core';
import { Flight } from "../_model/flight";
import { FlightService } from "../_service/flight.service";
import * as moment from 'moment';

@Component({
  selector: 'app-flight',
  templateUrl: './flight.component.html',
  styleUrls: ['./flight.component.scss']
})


export class FlightComponent implements OnInit {
  flights: Flight[];
  selectedDate: Date = new Date();
  constructor(private flightService: FlightService) {}

  ngOnInit() {
    this.getFlights();
  }

  getFlights(): void {
    this.flightService.getFlights().subscribe(flights => {
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
