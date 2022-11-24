import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TahapanComponent } from './tahapan.component';

describe('TahapanComponent', () => {
  let component: TahapanComponent;
  let fixture: ComponentFixture<TahapanComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ TahapanComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(TahapanComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
