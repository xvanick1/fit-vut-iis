import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CreateAirplaneTypeComponent } from './create-airplane-type.component';

describe('CreateAirplaneTypeComponent', () => {
  let component: CreateAirplaneTypeComponent;
  let fixture: ComponentFixture<CreateAirplaneTypeComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CreateAirplaneTypeComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CreateAirplaneTypeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
