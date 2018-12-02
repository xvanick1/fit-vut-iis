import { ApiDate } from "./api-date";
import { Time } from "@angular/common";
import {Airplane} from "./airplane";
import {Terminal} from "./terminal";
import {Gate} from "./gate";

export class Flight {
  id: number;
  destination: string;
  _dateOfDeparture: Date;
  _timeOfDeparture: Time;
  _flightLength: Time;
  terminal: Terminal;
  gate: Gate;
  airplane: Airplane;
  //api
  timeOfDeparture: ApiDate;
  dateOfDeparture: ApiDate;
  flightLength: ApiDate;
  _submitted: boolean;
}
