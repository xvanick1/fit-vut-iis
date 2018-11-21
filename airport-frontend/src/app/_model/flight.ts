import { ApiDate } from "./api-date";
import { Time } from "@angular/common";
import {Airplane} from "./airplane";
import {Terminal} from "./terminal";
import {Gate} from "./gate";

export class ApiFlight {
  id: number;
  destination: string;
  timeOfDeparture: ApiDate;
  dateOfDeparture: ApiDate;
  terminal: string;
  gate: string;
}

export class Flight {
  id: number;
  destination: string;
  time: Time;
  date: Date;
  terminal: string;
  gate: string;
}

export class formFlight {
  destination: string;
  time: Time;
  date: Date;
  flightLength: Time;
  airplaineID: number;
  gateID: number;
  terminalID: number;
}
