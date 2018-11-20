import { Time } from "@angular/common";

export class Flight {
  id: number;
  destination: string;
  timeOfDeparture: Time;
  dateOfDeparture: Date;
  terminal: string;
  gate: string;
}
