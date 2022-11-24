import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import {BerandaComponent} from './beranda/beranda.component';
import {SeksiComponent} from './seksi/seksi.component';
import {CapaianComponent} from './capaian/capaian.component';
import {CKPComponent} from './ckp/ckp.component';
import {DLComponent} from './dl/dl.component';
import {KegiatanComponent} from './kegiatan/kegiatan.component';
import {TahapanComponent} from './tahapan/tahapan.component';
import {UserComponent} from './user/user.component';
import {IndividuComponent} from './individu/individu.component'
import {ErrorComponent} from './error/error.component';
import {TambahKegiatanComponent} from './tambah-kegiatan/tambah-kegiatan.component';
import {TahapanCapaianComponent} from './tahapan-capaian/tahapan-capaian.component'



const routes: Routes = [
  { path: '', component: BerandaComponent },
  { path: 'home', component: BerandaComponent },
  { path: 'seksi', component: SeksiComponent },
  { path: 'individu', component: IndividuComponent },
  { path: 'capaian/get', component: CapaianComponent },
  { path: 'ckp', component: CKPComponent },
  { path: 'dl', component: DLComponent },
  { path: 'kegiatan/tambah_kegiatan', component: TambahKegiatanComponent },
  { path: 'kegiatan/:id' ,
    children: [
      { path: '', component: KegiatanComponent} ,
      { path: 'tahapan/:idtahapan/show', component: TahapanComponent},
      { path: 'tahapan/:idtahapan/capaian/show', component: TahapanCapaianComponent}
    ]
  },
  { path: 'user', component: UserComponent },
  { path: 'error/:id', component: ErrorComponent },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { 
}
