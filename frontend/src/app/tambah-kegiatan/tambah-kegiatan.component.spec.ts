import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TambahKegiatanComponent } from './tambah-kegiatan.component';

describe('TambahKegiatanComponent', () => {
  let component: TambahKegiatanComponent;
  let fixture: ComponentFixture<TambahKegiatanComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ TambahKegiatanComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(TambahKegiatanComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
