import { Component, OnInit } from '@angular/core';
import {AirplaneClass} from '../_model/airplane-class';
import {FormControl, FormGroup, Validators} from '@angular/forms';
import {AirplaneClassService} from '../_service/airplane-class.service';
import * as modal from "../_helper/modal";
import {AirTypeGate} from "../_model/gate";

@Component({
  selector: 'app-airplane-class',
  templateUrl: './airplane-class.component.html',
  styleUrls: ['./airplane-class.component.scss']
})
export class AirplaneClassComponent implements OnInit {
  myForm: FormGroup;
  airplaneClassForm: FormGroup;
  airplaneClasses: AirplaneClass[];
  tmpAirplaneClass: AirplaneClass;
  submitted: boolean = false;
  isError: boolean = false;

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

    this.airplaneClassForm = new FormGroup({
      'airplaneClassName': new FormControl('', [
        Validators.required,
        Validators.pattern('^\\S.*$'),
        Validators.maxLength(190)
      ]),
    });

    this.onChanges();
    this.getAirplaneClasses();
  }

  onChanges(): void {
    this.myForm.valueChanges.subscribe(() => {
      this.getAirplaneClasses();
    });
  }

  deleteAirplaneClass(airplaneClass: AirplaneClass) {
    if (airplaneClass._submitted) {
      return;
    }
    airplaneClass._submitted = true;

    this.airplaneClassService.deleteAirplaneClass(airplaneClass.id).subscribe(
      () => {
        let airplaneClasses = [];
        for (let airClass of this.airplaneClasses) {
          if (airClass !== airplaneClass) {
            airplaneClasses.push(airClass);
          }
        }
        this.airplaneClasses = airplaneClasses;
      },
      () => {
        airplaneClass._submitted = false;
      });
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


  closeModal(id: string) {
    modal.closeModal(id);
    this.isError = false;
  }

  addAirplaneClass(id: string, airClass: AirplaneClass) {
    modal.openModal(id);
    this.submitted = false;
    this.tmpAirplaneClass = new AirplaneClass();
    if (airClass) {
      this.airplaneClassForm.get('airplaneClassName').setValue(airClass.name);
      this.tmpAirplaneClass.id = airClass.id;
    } else {
      this.airplaneClassForm.get('airplaneClassName').setValue(null);
    }
  }

  saveButton(id: string) {
    this.submitted = true;
    this.isError = false;
    this.tmpAirplaneClass.name = this.airplaneClassForm.get('airplaneClassName').value;
    for (let airClass of this.airplaneClasses) { // check if name is unique
      if (airClass.name === this.tmpAirplaneClass.name) {
        modal.closeModal(id);
        return;
      }
    }

    if (this.tmpAirplaneClass.id) {
      this.airplaneClassService.updateAirplaneClass(this.tmpAirplaneClass.id, this.tmpAirplaneClass.name).subscribe(() => {
        for (let airClass of this.airplaneClasses) { // update name is unique
          if (airClass.id === this.tmpAirplaneClass.id) {
            airClass.name = this.tmpAirplaneClass.name;
          }
        }
        modal.closeModal(id);
      }, () => {
        this.isError = true;
        this.submitted = false;
      });
    } else {
      this.airplaneClassService.createAirplaneClass(this.tmpAirplaneClass.name).subscribe(resp => {
        this.tmpAirplaneClass.countOfSeats = 0;
        this.tmpAirplaneClass.countOfAirplanes = 0;
        this.tmpAirplaneClass.id = resp.id;
        this.airplaneClasses.push(this.tmpAirplaneClass);
        modal.closeModal(id);
      },() => {
        this.isError = true;
        this.submitted = false;
      });
    }
  }
}
