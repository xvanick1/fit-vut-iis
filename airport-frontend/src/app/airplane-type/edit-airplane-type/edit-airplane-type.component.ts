import { Component, OnInit } from '@angular/core';
import {FormControl, Validators} from "@angular/forms";
import {Message} from "../../_model/message";
import {AirplaneType} from "../../_model/airplane-type";
import {AirplaneTypeService} from "../../_service/airplane-type.service";
import {ActivatedRoute, Router} from "@angular/router";

@Component({
  selector: 'app-edit-airplane-type',
  templateUrl: '../form-airplane-type.component.html',
  styleUrls: ['../form-airplane-type.component.scss']
})
export class EditAirplaneTypeComponent implements OnInit {
  title = 'Upravit Typ letadla';
  submitted: boolean = false;
  isLoading: boolean = true;
  created: boolean = false;
  message: Message;
  airplaneType: AirplaneType;

  constructor(
    private airplaneTypeService: AirplaneTypeService,
    private router: Router,
    private route: ActivatedRoute
  ) { }

  ngOnInit() {
    this.airplaneType = new AirplaneType();
    this.route.params.subscribe(params => {
      this.airplaneType.id = +params['id'];
      // In a real app: dispatch action to load the details here.
    });

    this.airplaneTypeService.getAirplaneType(this.airplaneType.id).subscribe(
      resp => {
        this.airplaneType = resp.body;
        this.isLoading = false;
      },
      error1 => {
        this.router.navigate(['404']);
      });
  }

  onSubmit() {
    this.submitted = true;
    this.message = null;
    this.airplaneTypeService.updateAirplaneType(this.airplaneType.id).subscribe(resp => {
      this.message = new Message();
      this.message.type = 'success';
      this.message.text = 'Typ letadla byl úspěšně uložen';
      this.submitted = false;
    }, error1 => {
      this.message = new Message();
      this.message.type = 'alert';
      this.message.text = 'Při ukládání typu letadla nastala chyba';
      this.submitted = false;
    });
  }

  deleteAirplaneType() {
    this.submitted = true;
    this.message = null;
    this.airplaneTypeService.deleteAirplaneType(this.airplaneType.id).subscribe(resp => {
      this.router.navigate(['terminaly']);
    }, error1 => {
      this.message = new Message();
      this.message.type = 'alert';
      this.message.text = 'Při mazání typu letadla nastala chyba';
      this.submitted = false;
    });
  }
}
