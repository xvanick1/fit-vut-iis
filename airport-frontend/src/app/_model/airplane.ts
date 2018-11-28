import {AirplaneType} from './airplane-type';
import {ApiDate} from "./api-date";

export class Airplane {
  id: number;
  type: AirplaneType;
  dateOfProduction: ApiDate;
  dateOfRevision: ApiDate;
  _dateOfProduction: Date;
  _dateOfRevision: Date;
  crewNumber: number;
  _submitted: boolean;
}

