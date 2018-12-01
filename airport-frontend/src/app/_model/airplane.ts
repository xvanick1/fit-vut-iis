import {AirplaneType} from './airplane-type';
import {ApiDate} from "./api-date";
import {Seat} from "./seat";

export class Airplane {
  id: number;
  type: AirplaneType;
  dateOfProduction: ApiDate;
  dateOfRevision: ApiDate;
  _dateOfProduction: Date;
  _dateOfRevision: Date;
  crewNumber: number;
  countOfSeats: number;
  _submitted: boolean;
  seats: Seat[];
  deletedSeats: Seat[];
  updatedSeats: Seat[];
}

