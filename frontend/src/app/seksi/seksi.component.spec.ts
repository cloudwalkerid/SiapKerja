import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SeksiComponent } from './seksi.component';

describe('SeksiComponent', () => {
  let component: SeksiComponent;
  let fixture: ComponentFixture<SeksiComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ SeksiComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(SeksiComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
