import { Component, OnInit } from '@angular/core';
import {FlightService} from "../../_service/flight.service";
import {ActivatedRoute, Router} from "@angular/router";
import {FormFlightComponent} from "../form-flight.component";
import * as moment from "moment";
import {AirplaneService} from "../../_service/airplane.service";
import {Airplane} from "../../_model/airplane";
import {Gate} from "../../_model/gate";
import {Message} from "../../_model/message";


@Component({
  selector: 'app-create-flight',
  templateUrl: '../form-flight.component.html',
  styleUrls: ['../form-flight.component.scss']
})
export class CreateFlightComponent extends FormFlightComponent implements OnInit {

  constructor(
    protected flightService: FlightService,
    protected airplaneService: AirplaneService,
    protected route: ActivatedRoute,
    protected router: Router
  ) {
    super(flightService, airplaneService, route, router);
  }

  ngOnInit() {
    this.getAirplanes();
    this.title = 'Vytvořit let';
    this.flight._flightLength = {hours: 1, minutes: 0};
    let now = moment();
    this.flight._timeOfDeparture = {hours: now.hours(), minutes: now.minutes()};
    this.flight._dateOfDeparture = now.toDate();
    this.flight.airplane = new Airplane();
    this.flight.gate = new Gate();
  }

  onSubmit() {
    if (this.created) {
      this.router.navigate(['lety/vytvorit']);
      return;
    }

    this.submitted = true;
    this.message = null;
    this.flightService.createFlight(this.flight).subscribe(resp => {
      this.message = new Message();
      this.message.type = 'success';
      this.message.text = 'Let bylo úspěšně vytvořeno';
      this.submitted = false;
      this.created = true;
    }, () => {
      this.message = new Message();
      this.message.type = 'alert';
      this.message.text = 'Při vytváření letu nastala chyba';
      this.submitted = false;
    });
  }

}
