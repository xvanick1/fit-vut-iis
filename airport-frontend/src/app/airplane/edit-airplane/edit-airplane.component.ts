import { Component, OnInit } from '@angular/core';
import {Airplane} from "../../_model/airplane";
import {Message} from "../../_model/message";
import * as moment from "moment";
import {AirplaneFormComponent} from "../airplane-form.component";
import {AirplaneService} from "../../_service/airplane.service";
import {AirplaneTypeService} from "../../_service/airplane-type.service";
import {ActivatedRoute, Router} from "@angular/router";
import {AirplaneClassService} from "../../_service/airplane-class.service";

@Component({
  selector: 'app-edit-airplane',
  templateUrl: '../form-airplane.component.html',
  styleUrls: ['../form-airplane.component.scss']
})
export class EditAirplaneComponent extends AirplaneFormComponent implements OnInit {
  title = 'Upravit letadlo';

  constructor(
    protected airplaneService: AirplaneService,
    protected airplaneTypeService: AirplaneTypeService,
    protected airplaneClassService: AirplaneClassService,
    protected router: Router,
    protected route: ActivatedRoute
  ) {
    super(airplaneService, airplaneTypeService, airplaneClassService, router, route);
    this.isLoading = true;
  }

  ngOnInit() {
    this.airplane = new Airplane();
    this.route.params.subscribe(params => {
      this.airplane.id = +params['id'];
      // In a real app: dispatch action to load the details here.
    });

    this.airplaneService.getAirplane(this.airplane.id).subscribe(resp => {
        this.airplane = resp.body;
        this.airplaneTypeInput.setValue(this.airplane.type.id);
        this.airplane._dateOfProduction = moment(this.airplane.dateOfProduction.date).toDate();
        this.airplane._dateOfRevision = moment(this.airplane.dateOfRevision.date).toDate();
        this.isLoading = false;
        this.airplane.deletedSeats = [];
        this.airplane.updatedSeats = [];
      },
      () => {
        this.router.navigate(['404']);
      });
  }

  onSubmit() {
    this.submitted = true;
    this.message = null;
    this.airplaneService.updateAirplane(this.airplane).subscribe(resp => {
      this.message = new Message();
      this.message.type = 'success';
      this.message.text = 'Letadlo bylo úspěšně uloženo';
      this.airplane.seats = resp.seats;
      this.submitted = false;
    }, () => {
      this.message = new Message();
      this.message.type = 'alert';
      this.message.text = 'Při ukládání letadla nastala chyba';
      this.submitted = false;
    });
  }

  deleteAirplane() {
    this.submitted = true;
    this.message = null;
    this.airplaneService.deleteAirplane(this.airplane.id).subscribe(() => {
      this.router.navigate(['letadla']);
    }, () => {
      this.message = new Message();
      this.message.type = 'alert';
      this.message.text = 'Při mazání letadla nastala chyba';
      this.submitted = false;
    });
  }

}
