import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { EditAirplaneTypeComponent } from './edit-airplane-type.component';

describe('EditAirplaneTypeComponent', () => {
  let component: EditAirplaneTypeComponent;
  let fixture: ComponentFixture<EditAirplaneTypeComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ EditAirplaneTypeComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(EditAirplaneTypeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
