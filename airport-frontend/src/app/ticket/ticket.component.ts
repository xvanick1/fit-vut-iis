import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from "@angular/forms";
import { DatePipe } from "@angular/common";
import { Ticket } from "../_model/ticket";
import {TicketService} from "../_service/ticket.service";
import {closeModal, openModal} from "../_helper/modal";
import {Seat} from "../_model/seat";

@Component({
  selector: 'app-ticket',
  templateUrl: './ticket.component.html',
  styleUrls: ['./ticket.component.scss']
})
export class TicketComponent implements OnInit {
  myForm: FormGroup;
  boardingForm: FormGroup;
  tickets: Ticket[];
  seats: Seat[];
  send: boolean = false;
  currentTicket: Ticket;

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

    this.boardingForm = new FormGroup({
      'nameInput': new FormControl('', [
        Validators.pattern('^\\S.*$')
      ]),
      'surnameInput': new FormControl('', [
        Validators.pattern('^\\S.*$')
      ]),
      'seat': new FormControl('', [

      ])
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

  getSeats(ticket: Ticket){
    this.seats = [];
    this.boardingForm.get('seat').disable();
    this.ticketService.getSeats(ticket.id).subscribe(seats => {
      this.seats = seats;
      this.boardingForm.get('seat').enable();
    });
  }

  printBoardingPass(ticket: Ticket) {

  }

  checkoutTicket(ticket: Ticket, id: string): void {
    this.currentTicket = ticket;
    this.getSeats(ticket);
    openModal(id);
    this.boardingForm.get('nameInput').setValue(ticket.name);
    this.boardingForm.get('surnameInput').setValue(ticket.surname);
  }

  closeModal(id: string) {
    if (this.send) {
      return;
    }
    this.currentTicket = null;
    closeModal(id);
    this.boardingForm.reset();
  }

  saveButton(id: string) {
    if (!this.boardingForm.valid) {
      return;
    }

    this.send = true;
    let name = this.boardingForm.get('nameInput').value;
    let surname = this.boardingForm.get('surnameInput').value;
    let seat = parseInt(this.boardingForm.get('seat').value);

    this.ticketService.checkout(this.currentTicket.id, name, surname, seat).subscribe(
      () => {

        let tickets = [];
        for (let ticket of this.tickets) {
          if (ticket !== this.currentTicket) {
            tickets.push(ticket);
          }
        }
        this.tickets = tickets;

        this.send = false;
        this.closeModal(id);
      },() => {
        this.send = false;
      });
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
