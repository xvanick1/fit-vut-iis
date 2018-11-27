import { Directive } from '@angular/core';
import { FormControl, NG_VALIDATORS } from "@angular/forms";

export function timeValidator(control: FormControl) {
  let ok = /^(([01][0-9])|(2[0-3])):[0-5][0-9]$/.test(control.value);
  if (!ok && control.value === null){
    return null;
  }
  return !ok ? {'time': {value: control.value}} : null;
}

@Directive({
  selector: '[appTime]',
  providers: [{provide: NG_VALIDATORS, useValue: timeValidator, multi: true}]
})

export class TimeValidatorDirective {}
