import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AirplaneClassComponent } from './airplane-class.component';

describe('AirplaneClassComponent', () => {
  let component: AirplaneClassComponent;
  let fixture: ComponentFixture<AirplaneClassComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ AirplaneClassComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AirplaneClassComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
