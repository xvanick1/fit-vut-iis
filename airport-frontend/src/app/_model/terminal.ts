import {Gate} from "./gate";

export class Terminal {
    id: number;
    name: string;
    countOfGates: number;
    _submitted: boolean;
    gates: Gate[];
    deletedGates: Gate[];
}
