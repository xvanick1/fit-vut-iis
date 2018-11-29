import { TestBed } from '@angular/core/testing';

import { AirplaneClassService } from './airplane-class.service';

describe('AirplaneClassService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: AirplaneClassService = TestBed.get(AirplaneClassService);
    expect(service).toBeTruthy();
  });
});
