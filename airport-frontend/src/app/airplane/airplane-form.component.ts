import {FormControl, FormGroup, Validators} from "@angular/forms";
import {Message} from "../_model/message";
import {Airplane} from "../_model/airplane";
import {AirplaneType} from "../_model/airplane-type";
import {AirplaneService} from "../_service/airplane.service";
import {AirplaneTypeService} from "../_service/airplane-type.service";
import {ActivatedRoute, Router} from "@angular/router";
import * as moment from "moment";
import * as modal from "../_helper/modal";
import {Seat} from "../_model/seat";
import {AirplaneClass} from "../_model/airplane-class";
import {AirplaneClassService} from "../_service/airplane-class.service";

export class AirplaneFormComponent {
  title: String;
  submitted: boolean = false;
  isLoading: boolean = false;
  created: boolean = false;
  airplaneTypeInput: FormControl;
  message: Message;
  airplane: Airplane;
  airplaneTypes: AirplaneType[];
  tmpSeat: Seat;
  seatForm: FormGroup;
  airplaneClasses: AirplaneClass[];

  constructor(
    protected airplaneService: AirplaneService,
    protected airplaneTypeService: AirplaneTypeService,
    protected airplaneClassService: AirplaneClassService,
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

    this.seatForm = new FormGroup({
      'seatNumber': new FormControl('', [
        Validators.required,
        Validators.pattern('[1-9][0-9]*')
      ]),
      'location': new FormControl('', [
        Validators.required,
        Validators.maxLength(6),
        Validators.pattern('^\\S.*$')
      ]),
      'airplaneClass': new FormControl('', [
        Validators.required
      ]),
    });

    this.airplaneClassService.getAllAirplaneClasses().subscribe(classes => this.airplaneClasses = classes);
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

  /**
   *  Seat modal
   */

  deleteSeat(seat: Seat) {
    if (seat.id) {
      this.airplane.deletedSeats.push(seat);
    }
    let seats: Seat[] = [];
    for(let tmp of this.airplane.seats) {
      if (tmp !== seat) {
        seats.push(tmp);
      }
    }
    this.airplane.seats = seats;
  }

  createSeat(id: string) {
    modal.openModal(id);
    this.seatForm.reset();
    this.tmpSeat = new Seat();
  }

  saveButton(id: string) {
    if (!this.tmpSeat.id) {
      let newSeat = new Seat();
      newSeat.seatNumber = this.seatForm.get('seatNumber').value;
      newSeat.location = this.seatForm.get('location').value;
      newSeat.airplaneClass = new AirplaneClass();
      newSeat.airplaneClass.id = this.seatForm.get('airplaneClass').value;
      for (let airClass of this.airplaneClasses) {
        if (airClass.id == newSeat.airplaneClass.id) {
          newSeat.airplaneClass.name = airClass.name;
          break;
        }
      }
      if (!this.airplane.seats.some(s => s.seatNumber == newSeat.seatNumber)) {
        this.airplane.seats.push(newSeat);
      }
    } else {
      this.tmpSeat.seatNumber = this.seatForm.get('seatNumber').value;
      this.tmpSeat.location = this.seatForm.get('location').value;
      this.tmpSeat.airplaneClass.id = this.seatForm.get('airplaneClass').value;
      for (let airClass of this.airplaneClasses) {
        if (airClass.id == this.tmpSeat.airplaneClass.id) {
          this.tmpSeat.airplaneClass.name = airClass.name;
          break;
        }
      }
      this.airplane.updatedSeats.push(this.tmpSeat);
    }
    modal.closeModal(id);
  }

  updateSeat(id: string, seat: Seat) {
    modal.openModal(id);
    this.seatForm.get('seatNumber').setValue(seat.seatNumber);
    this.seatForm.get('location').setValue(seat.location);
    this.seatForm.get('airplaneClass').setValue(seat.airplaneClass.id);
    this.tmpSeat = seat;
  }

  closeModal(id: string) {
    modal.closeModal(id);
  }
}
