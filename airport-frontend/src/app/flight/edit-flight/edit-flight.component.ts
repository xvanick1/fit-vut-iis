import { Component, OnInit } from '@angular/core';
import {FlightService} from "../../_service/flight.service";
import {ActivatedRoute, Router} from '@angular/router';
import {FormFlightComponent} from "../form-flight.component";
import * as moment from "moment";
import {AirplaneService} from "../../_service/airplane.service";
import {Message} from "../../_model/message";

@Component({
  selector: 'app-edit-flight',
  templateUrl: '../form-flight.component.html',
  styleUrls: ['../form-flight.component.scss']
})
export class EditFlightComponent extends FormFlightComponent implements OnInit {

  constructor(
    protected flightService: FlightService,
    protected airplaneService: AirplaneService,
    protected route: ActivatedRoute,
    protected router: Router
  ) {
    super(flightService, airplaneService, route, router);
  }

  ngOnInit() {
    this.title = 'Upravit let';
    this.route.params.subscribe(params => {
      this.flight.id = +params['id']; // (+) converts string 'id' to a number
      // In a real app: dispatch action to load the details here.
    });

    this.flightService.getFlight(this.flight.id).subscribe(resp => {
      if (resp.status == 200) {
        let flight = resp.body;
        this.flight.id = flight.id;
        this.flight.destination = flight.destination;
        let time = moment(flight.timeOfDeparture.date);
        this.flight._timeOfDeparture = {hours: time.hours(), minutes: time.minutes()};
        time = moment(flight.flightLength.date);
        this.flight._flightLength = {hours: time.hours(), minutes: time.minutes()};
        this.flight._dateOfDeparture = moment(flight.dateOfDeparture.date).toDate();
        this.flight.airplane = flight.airplane;
        this.flight.gate = flight.gate;
        this.getAirplanes();
        this.airplaneInput.setValue(this.flight.airplane.id);
        this.gateInput.setValue(this.flight.gate.id);
      } else {
        this.router.navigate(['404']);
      }
    });
  }

  onSubmit() {
    this.submitted = true;
    this.message = null;
    this.flightService.updateFlight(this.flight).subscribe(resp => {
      this.message = new Message();
      this.message.type = 'success';
      this.message.text = 'Let bylo úspěšně uloženo';
      this.submitted = false;
    }, () => {
      this.message = new Message();
      this.message.type = 'alert';
      this.message.text = 'Při ukládání letu nastala chyba';
      this.submitted = false;
    });
  }

  deleteFlight() {
    this.submitted = true;
    this.message = null;
    this.flightService.deleteFlight(this.flight.id).subscribe(() => {
      this.router.navigate(['lety']);
    }, () => {
      this.message = new Message();
      this.message.type = 'alert';
      this.message.text = 'Při mazání letu nastala chyba';
      this.submitted = false;
    });
  }
}
