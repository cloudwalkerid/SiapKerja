import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CKPComponent } from './ckp.component';

describe('CKPComponent', () => {
  let component: CKPComponent;
  let fixture: ComponentFixture<CKPComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ CKPComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(CKPComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
