import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TahapanCapaianComponent } from './tahapan-capaian.component';

describe('TahapanCapaianComponent', () => {
  let component: TahapanCapaianComponent;
  let fixture: ComponentFixture<TahapanCapaianComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ TahapanCapaianComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(TahapanCapaianComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
