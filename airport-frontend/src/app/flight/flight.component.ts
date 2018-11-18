import { Component, OnInit } from '@angular/core';
import { Flight } from "../flight";
import { FlightService } from "../flight.service";

@Component({
  selector: 'app-flight',
  templateUrl: './flight.component.html',
  styleUrls: ['./flight.component.scss']
})


export class FlightComponent implements OnInit {
  flights: Flight[];
  selectedDate: Date = new Date();
  constructor(private flightService: FlightService) { }

  ngOnInit() {
    this.getFlights();
  }

  getFlights(): void {
    this.flightService.getFlights().subscribe(flights => this.flights = flights);
  }

  cancelFlight(flight: Flight): void {

  }
}
