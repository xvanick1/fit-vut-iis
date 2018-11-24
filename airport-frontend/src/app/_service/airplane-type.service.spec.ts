import { TestBed } from '@angular/core/testing';

import { AirplaneTypeService } from './airplane-type.service';

describe('AirplaneTypeService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: AirplaneTypeService = TestBed.get(AirplaneTypeService);
    expect(service).toBeTruthy();
  });
});
