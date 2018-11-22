import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AirplaneTypeComponent } from './airplane-type.component';

describe('AirplaneTypeComponent', () => {
  let component: AirplaneTypeComponent;
  let fixture: ComponentFixture<AirplaneTypeComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ AirplaneTypeComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AirplaneTypeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
