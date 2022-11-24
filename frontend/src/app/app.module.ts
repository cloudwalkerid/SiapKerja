import { BrowserModule } from '@angular/platform-browser';
import { NgModule, CUSTOM_ELEMENTS_SCHEMA } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { HttpClientModule } from '@angular/common/http';
import { FormsModule } from '@angular/forms';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { BerandaComponent } from './beranda/beranda.component';
import { SeksiComponent } from './seksi/seksi.component';
import { CapaianComponent } from './capaian/capaian.component';
import { CKPComponent } from './ckp/ckp.component';
import { AkunComponent } from './akun/akun.component';
import { DLComponent } from './dl/dl.component';
import { KegiatanComponent } from './kegiatan/kegiatan.component';
import { TahapanComponent } from './tahapan/tahapan.component';
import { MyDataService } from './my-data.service';
import { UserComponent } from './user/user.component';
import { IndividuComponent } from './individu/individu.component';
import { ErrorComponent } from './error/error.component';
import { TambahKegiatanComponent } from './tambah-kegiatan/tambah-kegiatan.component';

import { NgxSpinnerModule } from 'ngx-spinner';
import { ChartsModule } from 'ng2-charts';
import { StatusUbahPipe } from './status-ubah.pipe';
import { NotNullPipe } from './not-null.pipe';
import { TahapanCapaianComponent } from './tahapan-capaian/tahapan-capaian.component';


@NgModule({
  declarations: [
    AppComponent,
    BerandaComponent,
    SeksiComponent,
    CapaianComponent,
    CKPComponent,
    AkunComponent,
    DLComponent,
    KegiatanComponent,
    TahapanComponent,
    UserComponent,
    IndividuComponent,
    ErrorComponent,
    TambahKegiatanComponent,
    StatusUbahPipe,
    NotNullPipe,
    TahapanCapaianComponent,
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    FormsModule,
    NgxSpinnerModule,
    ChartsModule,
    BrowserAnimationsModule,
  ],
  providers: [MyDataService],
  schemas: [CUSTOM_ELEMENTS_SCHEMA],
  bootstrap: [AppComponent]
})
export class AppModule { }
