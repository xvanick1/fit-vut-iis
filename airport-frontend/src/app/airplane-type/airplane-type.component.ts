import { Component, OnInit } from '@angular/core';
import {FormControl, FormGroup, Validators} from "@angular/forms";
import {AirplaneType} from "../_model/airplane-type";
import {AirplaneTypeService} from '../_service/airplane-type.service';

@Component({
  selector: 'app-airplane-type',
  templateUrl: './airplane-type.component.html',
  styleUrls: ['./airplane-type.component.scss']
})
export class AirplaneTypeComponent implements OnInit {
  myForm: FormGroup;
  airplaneTypes: AirplaneType[];

  constructor(
    private airplaneTypeService: AirplaneTypeService
  ) { }

  ngOnInit() {
    this.myForm = new FormGroup({
      'nameInput': new FormControl('', [
        Validators.pattern('[1-9][0-9]*')
      ]),
      'manufacturerInput': new FormControl(),
      'countOfAirplaneTypeInput': new FormControl('', [
        Validators.pattern('[1-9][0-9]*')
      ]),
    });

    this.onChanges();
    this.getAirplaneTypes();
  }

  onChanges(): void {
    this.myForm.valueChanges.subscribe(value => {
      this.getAirplaneTypes();
    });
  }

  getAirplaneTypes(): void {
    const params = new Map();
    if (!this.myForm.valid) {
      return;
    }

    params.set('name', this.myForm.get('nameInput').value);
    params.set('manufacturer', this.myForm.get('manufacturerInput').value);
    params.set('countOfAirplaneType', this.myForm.get('countOfAirplaneTypeInput').value);

    this.airplaneTypes = [];
    this.airplaneTypeService.getAirplaneTypes(params).subscribe(airplaneTypes => {
      this.airplaneTypes = airplaneTypes;
    });
  }

  deleteAirplaneType(airplaneType: AirplaneType) {
    if (airplaneType._submitted) {
      return;
    }
    airplaneType._submitted = true;

    this.airplaneTypeService.deleteAirplaneType(airplaneType.id).subscribe( //deleting by ID or name? not sure, but ID is unique so given ID
      resp => {
        let airplaneTypes = [];
        for (let tmp of this.airplaneTypes) {
          if (tmp !== airplaneType) {
            airplaneTypes.push(tmp);
          }
        }
        this.airplaneTypes = airplaneTypes;
      },
      error1 => {
        airplaneType._submitted = false;
      });
  }

}
