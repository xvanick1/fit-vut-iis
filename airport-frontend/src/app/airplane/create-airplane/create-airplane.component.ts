import { Component, OnInit } from '@angular/core';
import {Message} from "../../_model/message";
import {Airplane} from "../../_model/airplane";
import {AirplaneType} from "../../_model/airplane-type";
import {AirplaneFormComponent} from "../airplane-form.component";
import {AirplaneService} from "../../_service/airplane.service";
import {AirplaneTypeService} from "../../_service/airplane-type.service";
import {ActivatedRoute, Router} from "@angular/router";

@Component({
  selector: 'app-create-airplane',
  templateUrl: '../form-airplane.component.html',
  styleUrls: ['../form-airplane.component.scss']
})
export class CreateAirplaneComponent extends AirplaneFormComponent implements OnInit {
  title = 'Vytvořit letadlo';
  isLoading: boolean = true;

  constructor(
    protected airplaneService: AirplaneService,
    protected airplaneTypeService: AirplaneTypeService,
    protected router: Router,
    protected route: ActivatedRoute
  ) {
    super(airplaneService, airplaneTypeService, router, route);
    this.isLoading = false;
  }

  ngOnInit() {
    this.airplane = new Airplane();
    this.airplane._dateOfProduction = new Date();
    this.airplane._dateOfRevision = new Date();
    this.airplane.type = new AirplaneType();
  }

  onSubmit() {
    if (this.created) {
      this.router.navigate(['letadla/vytvorit']);
      return;
    }

    this.submitted = true;
    this.message = null;
    console.log(this.airplane);
    this.airplaneService.createAirplane(this.airplane).subscribe(resp => {
      this.message = new Message();
      this.message.type = 'success';
      this.message.text = 'Letadlo bylo úspěšně vytvořeno';
      this.submitted = false;
      this.created = true;
    }, error1 => {
      this.message = new Message();
      this.message.type = 'alert';
      this.message.text = 'Při vytváření letadla nastala chyba';
      this.submitted = false;
    });
  }
}
