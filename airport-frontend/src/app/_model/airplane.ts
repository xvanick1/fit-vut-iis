export class AirplaneType {
  id: number;
  manufacturer: string;
  name: string;
}

export class Airplane {
  id: number;
  type: AirplaneType;
  dateOfProduction: Date;
  dateOfRevision: Date;
  crewNumber: number;
}

