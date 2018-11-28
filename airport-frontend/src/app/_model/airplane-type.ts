import {AirTypeGate} from "./gate";

export class AirplaneType {
  id: number;
  name: string;
  manufacturer: string;
  _submitted: boolean;
  countOfAirplanes: number;
  gates: AirTypeGate[];
  deletedGates: AirTypeGate[];
}
