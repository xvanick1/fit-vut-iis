import { Component, OnInit } from '@angular/core';
import {Airplane} from "../../_model/airplane";
import {Message} from "../../_model/message";
import {AirplaneService} from "../../_service/airplane.service";
import {ActivatedRoute, Router} from "@angular/router";

@Component({
  selector: 'app-edit-airplane',
  templateUrl: '../form-airplane.component.html',
  styleUrls: ['../form-airplane.component.scss']
})
export class EditAirplaneComponent implements OnInit {
  title = 'Upravit letadlo';
  submitted: boolean = false;
  isLoading: boolean = false;
  created: boolean = false;
  message: Message;
  airplane: Airplane;


  constructor(
    private airplaneService: AirplaneService,
    private router: Router,
    private route: ActivatedRoute
  ) { }

  ngOnInit() {
    this.airplane = new Airplane();
    this.route.params.subscribe(params => {
      this.airplane.id = +params['id'];
      // In a real app: dispatch action to load the details here.
    });

    this.airplaneService.getAirplane(this.airplane.id).subscribe(resp => {
      this.airplane = resp.body;
      this.isLoading = false;
    },
      error1 => {
      this.router.navigate(['404']);
      });
  }

  onSubmit() {
    this.submitted = true;
    this.message = null;
    this.airplaneService.updateAirplane(this.airplane).subscribe(resp => {
      this.message = new Message();
      this.message.type = 'success';
      this.message.text = 'Letadlo bylo úspěšně uloženo';
      this.submitted = false;
    }, error1 => {
      this.message = new Message();
      this.message.type = 'alert';
      this.message.text = 'Při ukládání letadla nastala chyba';
      this.submitted = false;
    });
  }

  deleteAirplane() {
    this.submitted = true;
    this.message = null;
    this.airplaneService.deleteAirplane(this.airplane.id).subscribe(resp => {
      this.router.navigate(['letadla']);
    }, error1 => {
      this.message = new Message();
      this.message.type = 'alert';
      this.message.text = 'Při mazání letadla nastala chyba';
      this.submitted = false;
    });
  }

}
