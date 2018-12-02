import {Seat} from "./seat";

export class Ticket {
  id: number;
  flight: number;
  surname: string;
  name: string;
  airplaneClass: string;
  destination: string;
  seat: Seat;
  boardingPass: number;
}
