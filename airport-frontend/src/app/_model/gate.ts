import {Terminal} from "./terminal";

export class Gate {
  id: number;
  name: string;
  terminal: Terminal;
}

export class AirTypeGate extends Gate{
  terminalName: string;
}
