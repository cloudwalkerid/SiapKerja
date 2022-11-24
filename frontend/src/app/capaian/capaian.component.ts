import { Component, OnInit } from '@angular/core';
import { MyDataService } from '../my-data.service';
import { Capaian_Tahapan, Capaian_Individu, Kegiatan, Tahapan_Kegiatan } from '../Object/Object';
import { NgxSpinnerService } from 'ngx-spinner';
import Swal from 'sweetalert2';

declare var $: any;

@Component({
  selector: 'app-capaian',
  templateUrl: './capaian.component.html',
  styleUrls: ['./capaian.component.css']
})
export class CapaianComponent implements OnInit {

  isFirst: boolean = true;
  show: boolean = true;
  capaianIndividu: Capaian_Individu[] = [];
  capaianIndividuOriginasl: Capaian_Individu[] = [];

  bulan_nama: string[] = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'
                  , 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
  bulan_index: number = 0;


  constructor(public myData: MyDataService, private spinner: NgxSpinnerService) {
      this.bulan_index = myData.bulan_aktive;
      this.spinner.show();
   }

  ngOnInit(): void {
    this.spinner.show();
    this.loadDataCapaian();
  }

  loadDataCapaian(): void{
    this.myData.getIndividu().subscribe({
      next: data => this.processData(data),
      error: error => console.error('Error get Kegiatan', error)
    });
  }

  processData(data: any): void{
    console.log('Process Data');
    if(this.isFirst){
      this.spinner.hide();
      this.isFirst = false;
    }
    data.forEach(element => {
      let itemIndividu = new Capaian_Individu();
      itemIndividu.setData(element);
      this.capaianIndividu.push(itemIndividu);
      let itemIndividuOriginal = new Capaian_Individu();
      itemIndividuOriginal.setData(element);
      this.capaianIndividuOriginasl.push(itemIndividuOriginal);
    });
    this.reRenderTable();
  }

  clean(): void{
   this.capaianIndividu = [];
   this.capaianIndividuOriginasl.forEach(element => {
     let item = new Capaian_Individu();
     item.setData(JSON.parse(JSON.stringify(element)));
     this.capaianIndividu.push(item);
   });
  }

  onUbah(itemCapaianIndividu: Capaian_Individu): void{
    itemCapaianIndividu.isEdit = 1;
  }


  onSubmitUpdateIndividu(itemCapaianIndividu: Capaian_Individu): void{
    this.spinner.show();
    this.myData.updateCapaianIndividu(itemCapaianIndividu).subscribe({
      next: data => this.onSubmitUpdateIndividuProcess(1, itemCapaianIndividu),
      error: error =>  this.onSubmitUpdateIndividuProcess(0, itemCapaianIndividu)
    });
  }
  onSubmitUpdateIndividuProcess(hasil: number,ubahCapaianIndividu: Capaian_Individu): void{
    if(hasil == 0){
      this.capaianIndividuOriginasl.forEach(element => {
        if(element.id == ubahCapaianIndividu.id){
          ubahCapaianIndividu.realisasi_01 = element.realisasi_01;
          ubahCapaianIndividu.realisasi_02 = element.realisasi_02;
          ubahCapaianIndividu.realisasi_03 = element.realisasi_03;
          ubahCapaianIndividu.realisasi_04 = element.realisasi_04;
          ubahCapaianIndividu.realisasi_05 = element.realisasi_05;
          ubahCapaianIndividu.realisasi_06 = element.realisasi_06;
          ubahCapaianIndividu.realisasi_07 = element.realisasi_07;
          ubahCapaianIndividu.realisasi_08 = element.realisasi_08;
          ubahCapaianIndividu.realisasi_09 = element.realisasi_09;
          ubahCapaianIndividu.realisasi_10 = element.realisasi_10;
          ubahCapaianIndividu.realisasi_11 = element.realisasi_11;
          ubahCapaianIndividu.realisasi_12 = element.realisasi_12;
        }
      });
      Swal.fire(
        'Gagal!',
        'Gagal memperbarui realisasi.',
        'error'
      );
    }else if(hasil == 1){
      this.capaianIndividuOriginasl.forEach(element => {
        if(element.id == ubahCapaianIndividu.id){
          element.realisasi_01 = ubahCapaianIndividu.realisasi_01;
          element.realisasi_02 = ubahCapaianIndividu.realisasi_02;
          element.realisasi_03 = ubahCapaianIndividu.realisasi_03;
          element.realisasi_04 = ubahCapaianIndividu.realisasi_04;
          element.realisasi_05 = ubahCapaianIndividu.realisasi_05;
          element.realisasi_06 = ubahCapaianIndividu.realisasi_06;
          element.realisasi_07 = ubahCapaianIndividu.realisasi_07;
          element.realisasi_08 = ubahCapaianIndividu.realisasi_08;
          element.realisasi_09 = ubahCapaianIndividu.realisasi_09;
          element.realisasi_10 = ubahCapaianIndividu.realisasi_10;
          element.realisasi_11 = ubahCapaianIndividu.realisasi_11;
          element.realisasi_12 = ubahCapaianIndividu.realisasi_12;
        }
      });
      Swal.fire(
        'Berhasil!',
        'Berhasil memperbarui realisasi.',
        'success'
      );
    }
    ubahCapaianIndividu.isEdit = 0;
    this.reRenderTable();
  }

  reRenderTable(): void{
    this.spinner.show();
    setTimeout(() => this.show = true);
    this.show = false;
    setTimeout(() => this.show = true);
    $(
      function() {
        $("#table-1").dataTable();
        $("#table-2").dataTable();
      }
    );
    this.spinner.hide();
  }

  getTergetBulan(capaianIndividu: Capaian_Individu): number {
    return capaianIndividu.getTergetBulan(parseInt(this.bulan_index.toString()));
  }
  getRealisasiBulan(capaianIndividu: Capaian_Individu): number {
    return capaianIndividu.getRealisasiBulan(parseInt(this.bulan_index.toString()));
  }
}
