import { Component } from '@angular/core';
import { Meta } from '@angular/platform-browser';
import { MyDataService } from './my-data.service';


@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'frontend';

  adaSeksi: boolean = true;

  constructor(public myData: MyDataService){
    let userdata = (<any>window).user;
    let allseksi = (<any>window).allseksi;
    let seksi_kepala = (<any>window).seksi_kepala;
    this.myData.kepala_seksi = seksi_kepala;
    this.myData.setUser(userdata);
    this.myData.setSeksi(allseksi);
    this.myData.showmyKegiatan();
    if(myData.myUser.seksi == null){
      this.adaSeksi = false;
    }else{
      this.adaSeksi = true;
    }
    console.log(seksi_kepala);
    if(this.myData.myUser.seksi_id == this.myData.kepala_seksi){
      this.myData.user_is_kepala = true;
    }else{
      this.myData.user_is_kepala = false;
    }
  }
}
