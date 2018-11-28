import { Component, OnInit } from '@angular/core';
import {AirplaneService} from '../_service/airplane.service';
import {FormControl, FormGroup, Validators} from '@angular/forms';
import {Airplane} from '../_model/airplane';

@Component({
  selector: 'app-airplane',
  templateUrl: './airplane.component.html',
  styleUrls: ['./airplane.component.scss']
})
export class AirplaneComponent implements OnInit {
  myForm: FormGroup;
  airplanes: Airplane[];

  constructor(
    private airplaneService: AirplaneService
  ) { }

  ngOnInit() {
    this.myForm = new FormGroup({
      'idInput': new FormControl('', [
        Validators.pattern('[1-9][0-9]*')
      ]),
      'nameInput': new FormControl(),
      'crewNumber': new FormControl('', [
        Validators.pattern('[1-9][0-9]*')
      ])
    });

    this.onChanges();
    this.getAirplanes();
  }

  onChanges(): void {
    this.myForm.valueChanges.subscribe(value => {
      this.getAirplanes();
    });
  }

  getAirplanes() {
    this.airplaneService.getAirplanes().subscribe(airplanes => {
      this.airplanes = airplanes;
    });
  }

  deleteAirplane(airplane: Airplane) {
    if (airplane._submitted) {
      return;
    }
    airplane._submitted = true;

    this.airplaneService.deleteAirplane(airplane.id).subscribe(
      resp => {},
      error1 => {
        airplane._submitted = false;
      });
  }

}
