import { Component, OnInit } from '@angular/core';
import {Message} from "../../_model/message";
import {Airplane} from "../../_model/airplane";
import {AirplaneService} from "../../_service/airplane.service";
import {ActivatedRoute, Router} from "@angular/router";
import {AirplaneType} from "../../_model/airplane-type";
import {AirplaneTypeService} from "../../_service/airplane-type.service";
import {FormControl, Validators} from "@angular/forms";

@Component({
  selector: 'app-create-airplane',
  templateUrl: '../form-airplane.component.html',
  styleUrls: ['../form-airplane.component.scss']
})
export class CreateAirplaneComponent implements OnInit {
  title = 'Vytvořit letadlo';
  submitted: boolean = false;
  isLoading: boolean = false;
  created: boolean = false;
  airplaneTypeInput: FormControl;
  message: Message;
  airplane: Airplane;
  airplaneTypes: AirplaneType[];

  constructor(
    private airplaneService: AirplaneService,
    private router: Router,
    private route: ActivatedRoute,
    private airplaneTypeService: AirplaneTypeService
  ) { }

  ngOnInit() {
    this.airplaneTypeInput = new FormControl('', [
      Validators.required
    ]);
    this.airplane = new Airplane();
    this.airplane.type = new AirplaneType();
    this.airplaneTypeService.getAirplaneTypes(null).subscribe(resp => {
      this.airplaneTypes = resp;
    });
  }

  onSubmit() {
    if (this.created) {
      this.router.navigate(['letadla/vytvorit']);
      return;
    }

    this.submitted = true;
    this.message = null;
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
