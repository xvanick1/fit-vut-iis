import {AirplaneType} from './airplane-type';
import {ApiDate} from "./api-date";

export class Airplane {
  id: number;
  type: AirplaneType;
  dateOfProduction: ApiDate;
  dateOfRevision: ApiDate;
  crewNumber: number;
  _submitted: boolean;
}

