import { Component, OnInit } from '@angular/core';
import {AirplaneClass} from "../_model/airplane-class";
import {FormControl, FormGroup, Validators} from "@angular/forms";
import {AirplaneClassService} from "../_service/airplane-class.service";

@Component({
  selector: 'app-airplane-class',
  templateUrl: './airplane-class.component.html',
  styleUrls: ['./airplane-class.component.scss']
})
export class AirplaneClassComponent implements OnInit {
  myForm: FormGroup;
  airplaneClasses: AirplaneClass[];

  constructor(
    private airplaneClassService: AirplaneClassService
  ) { }

  ngOnInit() {
    this.myForm = new FormGroup({
      'nameInput': new FormControl('', [
        Validators.maxLength(190),
        Validators.pattern('^\\S.*$')
      ]),
      'countOfAirplanes': new FormControl('', [
        Validators.pattern('[0-9]*'),
      ]),
      'countOfSeats': new FormControl('', [
        Validators.pattern('[0-9]*')
      ])
    });

    this.getAirplaneClasses();
  }

  deleteAirplaneClass(airplaneClass: AirplaneClass) {

  }

  getAirplaneClasses() {
    if (!this.myForm.valid) {
      return;
    }

    this.airplaneClasses = [];
    let params = new Map();
    params.set('name', this.myForm.get('nameInput').value);
    params.set('countOfSeats', this.myForm.get('countOfSeats').value);
    params.set('countOfAirplanes', this.myForm.get('countOfAirplanes').value);

    this.airplaneClassService.getAirplaneClasses(params).subscribe( airplaneClasses => this.airplaneClasses = airplaneClasses);
  }

}
