import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AkunComponent } from './akun.component';

describe('AkunComponent', () => {
  let component: AkunComponent;
  let fixture: ComponentFixture<AkunComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ AkunComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(AkunComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
