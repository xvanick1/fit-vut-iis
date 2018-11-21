import { ApiDate } from "./api-date";
import { Time } from "@angular/common";

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
