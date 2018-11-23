import { ApiDate } from "./api-date";
import { Time } from "@angular/common";
import {Airplane} from "./airplane";
import {Terminal} from "./terminal";
import {Gate} from "./gate";

export class Terminal {
    id: number;
    name: string;
    countOfGates: number;
    _submitted: boolean;
}