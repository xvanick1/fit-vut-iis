import {FormControl, Validators} from "@angular/forms";
import {Message} from "../_model/message";
import {Airplane} from "../_model/airplane";
import {AirplaneType} from "../_model/airplane-type";
import {AirplaneService} from "../_service/airplane.service";
import {AirplaneTypeService} from "../_service/airplane-type.service";
import {ActivatedRoute, Router} from "@angular/router";
import * as moment from "moment";

export class AirplaneFormComponent {
  title: String;
  submitted: boolean = false;
  isLoading: boolean = false;
  created: boolean = false;
  airplaneTypeInput: FormControl;
  message: Message;
  airplane: Airplane;
  airplaneTypes: AirplaneType[];


  constructor(
    protected airplaneService: AirplaneService,
    protected airplaneTypeService: AirplaneTypeService,
    protected router: Router,
    protected route: ActivatedRoute
  ) {
    this.airplaneTypeService.getAirplaneTypes(null).subscribe(resp => {
      this.airplaneTypes = resp;
    });

    this.airplaneTypeInput = new FormControl('', [
      Validators.required
    ]);

    this.onChange();
  }

  onChange() {
    this.airplaneTypeInput.valueChanges.subscribe(() => {
      this.airplane.type.id = this.airplaneTypeInput.value;
    });
  }

  changeProductionDate(value: any){
    if (!value.valid) {
      return;
    }
    this.airplane._dateOfProduction = moment(value.value).toDate();
  }

  changeRevisionDate(value: any){
    if (!value.valid) {
      return;
    }
    this.airplane._dateOfRevision = moment(value.value).toDate();
  }
}
