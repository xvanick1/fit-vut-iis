import { Time } from "@angular/common";

export class Flight {
  id: number;
  departureTime: Time;
  departureDate: Date;
  terminal: string;
  gate: string;
  destination: string;
}
