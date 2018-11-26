import {Gate} from "./gate";

export class AirplaneType {
  id: number;
  name: string;
  manufacturer: string;
  _submitted: boolean;
  countOfAirplanes: AirplaneType[];
  gates: Gate[];
}
