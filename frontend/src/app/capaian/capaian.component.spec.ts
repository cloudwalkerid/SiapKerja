import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CapaianComponent } from './capaian.component';

describe('CapaianComponent', () => {
  let component: CapaianComponent;
  let fixture: ComponentFixture<CapaianComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ CapaianComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(CapaianComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
