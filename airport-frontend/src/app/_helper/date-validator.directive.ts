import { Directive } from '@angular/core';
import { FormControl, NG_VALIDATORS } from "@angular/forms";

export function dateValidator(control: FormControl) {
  let ok = /^[12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/.test(control.value);
  if (!ok && control.value == ''){
    return null;
  }
  return !ok ? {'date': {value: control.value}} : null;
}

@Directive({
  selector: '[appDate]',
  providers: [{provide: NG_VALIDATORS, useValue: dateValidator, multi: true}]
})



export class DateValidatorDirective {}
