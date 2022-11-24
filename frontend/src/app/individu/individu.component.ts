import { Component, OnInit } from '@angular/core';
import { MyDataService } from '../my-data.service';
import { Capaian_Individu, Kegiatan } from '../Object/Object';
import { interval } from 'rxjs';
import { NgxSpinnerService } from 'ngx-spinner';

declare var $: any;

@Component({
  selector: 'app-individu',
  templateUrl: './individu.component.html',
  styleUrls: ['./individu.component.css']
})
export class IndividuComponent implements OnInit {

  capainIndividu: Capaian_Individu[] = [];
  capainIndividuShow: Capaian_Individu[] = [];
  show = true;
  bulan_index: number = 0;
  bulan_nama: string[] = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'
    , 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

  constructor(public myData: MyDataService, private spinner: NgxSpinnerService) {
    this.bulan_index = myData.bulan_aktive;
    this.spinner.show();
    this.loadDataIndividu();
    let minuteCounter = interval(15 * 60 * 1000);
    minuteCounter.subscribe(n =>
      this.loadDataIndividu());
  }

  ngOnInit(): void {
    this.spinner.show();
  }

  loadDataIndividu(): void{
    this.myData.getIndividu().subscribe({
      next: data => this.processData(data),
      error: error => console.error('Error get Kegiatan', error)
    });
  }

  processData(data: any): void{
    this.capainIndividu = [];
    this.capainIndividuShow = [];
    data.forEach(element => {
      let itemKegiatan = new Capaian_Individu();
      itemKegiatan.setData(element);
      this.capainIndividu.push(itemKegiatan);
    });
    this.capainIndividu.forEach(element => {
      if((element.checkIfAktiveInBulan(this.bulan_index))
        || ((element.checkIfBelumPenuhInBulan(this.bulan_index))) && (element.capaian_komulatif_all != 100)){
        this.capainIndividuShow.push(element);
      }
    });
    this.capainIndividuShow.sort(function(a,b):number{ return (a.capaian_komulatif_all) - b.capaian_komulatif_all});
    this.capainIndividuShow.forEach(element => {
      console.log(element.kegiatan_tahapan.nama+" : "+element.capaian_komulatif_all);
    });
    this.reRenderTable();
  }
  getSeksi(kegiatan: Kegiatan): string{
    let seksiNama = "";
    this.myData.all_seksi.forEach(element => {
      if(kegiatan.seksi_id == element.id){
        seksiNama = element.nama;
      }
    });
    return seksiNama;
  }
  reRenderTable(): void{
    this.spinner.show();
    setTimeout(() => this.show = true);
    this.show = false;
    setTimeout(() => this.show = true);
    $(
      function() {
        $("#table-1").dataTable();
      }
    );
    this.spinner.hide();
  }
}
