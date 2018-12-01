import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from "@angular/forms";
import { DatePipe } from "@angular/common";
import { Ticket } from "../_model/ticket";
import {TicketService} from "../_service/ticket.service";

@Component({
  selector: 'app-ticket',
  templateUrl: './ticket.component.html',
  styleUrls: ['./ticket.component.scss']
})
export class TicketComponent implements OnInit {
  myForm: FormGroup;
  tickets: Ticket[];
  constructor(
    private ticketService: TicketService,
    private datepipe: DatePipe,
  ) { }

  ngOnInit() {
    this.myForm = new FormGroup({
      'dateInput': new FormControl('', [
        Validators.pattern('([12]\\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\\d|3[01]))')
      ]),
      'timeInput': new FormControl('', [
        Validators.pattern('(([01][0-9])|(2[0-3])):[0-5][0-9]')
      ]),
      'ticketInput': new FormControl('', [
        Validators.pattern('[1-9][0-9]*')
      ]),
      'flightInput': new FormControl('', [
        Validators.pattern('[1-9][0-9]*')
      ]),
      'surnameInput': new FormControl('', [
        Validators.pattern('^\\S.*$')
      ]),
      'nameInput': new FormControl('', [
        Validators.pattern('^\\S.*$')
      ]),
      'classInput': new FormControl('', [
        Validators.maxLength(190),
        Validators.pattern('^\\S.*$')
      ]),
      'destinationInput': new FormControl('', [
        Validators.pattern('^\\S.*$')
      ]),
      'checkoutInput': new FormControl()
    });

    //this.seatForm.get('dateInput').setValue(this.datepipe.transform(new Date(), 'yyyy-MM-dd'));

    this.onChanges();
    this.getTickets();
  }

  onChanges(): void {
    this.myForm.valueChanges.subscribe(value => {
      this.getTickets();
    });
  }

  checkoutTicket(ticket: any): void {

  }

  getTickets(): void {
    let params = new Map();
    if (!this.myForm.valid) {
      return;
    }

    this.tickets = [];
    params.set('departureDate', this.myForm.get('dateInput').value);
    params.set('departureTime', this.myForm.get('timeInput').value);
    params.set('flightID', this.myForm.get('flightInput').value);
    params.set('destination', this.myForm.get('destinationInput').value);
    params.set('ticketID', this.myForm.get('ticketInput').value);
    params.set('surname', this.myForm.get('surnameInput').value);
    params.set('name', this.myForm.get('nameInput').value);
    params.set('airplaneClass', this.myForm.get('classInput').value);
    params.set('checkout', this.myForm.get('checkoutInput').value);

    this.ticketService.getTickets(params).subscribe(tickets => {
      this.tickets = tickets;
    });
  }
}
