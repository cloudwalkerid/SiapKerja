import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { MyDataService } from '../my-data.service';
import { Kegiatan, User, Mitra, Tahapan_Kegiatan, Capaian_Tahapan, Capaian_Individu, Tahapan_Alokasi_DL, Capaian_Individu_Pair_DL } from '../Object/Object';
import { NgxSpinnerService } from 'ngx-spinner';
import { Location } from '@angular/common';
import Swal from 'sweetalert2';

declare var $: any;

@Component({
  selector: 'app-tahapan-capaian',
  templateUrl: './tahapan-capaian.component.html',
  styleUrls: ['./tahapan-capaian.component.css']
})
export class TahapanCapaianComponent implements OnInit {

  idKegiatan: string;
  idTahapan: string;

  thisTahapanKegiatan: Tahapan_Kegiatan;
  thisTahapanKegiatanOriginas: Tahapan_Kegiatan;
  isFirst: boolean = true;

  users: User[];
  mitras: Mitra[];

  bulan_nama: string[] = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'
                  , 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];


  bulan_index: number = 0;
  show: boolean = true;



  constructor(public myData: MyDataService, private route: ActivatedRoute, private router: Router
    ,private spinner: NgxSpinnerService, private location: Location) {
      this.bulan_index = myData.bulan_aktive;
      this.spinner.show();
    }

  ngOnInit(): void {
    this.route.params.subscribe(routeParams => {
      this.isFirst = true;
      this.spinner.show();
      this.thisTahapanKegiatan = new Tahapan_Kegiatan();
      this.thisTahapanKegiatanOriginas = new Tahapan_Kegiatan();

      this.idKegiatan = this.route.snapshot.paramMap.get('id');
      this.idTahapan = this.route.snapshot.paramMap.get('idtahapan');

      this.users = [];
      this.mitras = [];

      this.loadDataTahapanKegiatan(this.idKegiatan, this.idTahapan);
      // let minuteCounter = interval(60 * 1000);
      // minuteCounter.subscribe(n =>
      //   this.loadDataTahapanKegiatan(this.idKegiatan, this.idTahapan));
      });
  }

  loadDataTahapanKegiatan(idKegiatan: string, idTahapan: string): void{
    this.myData.getTahapanKegiatan(idKegiatan, idTahapan).subscribe({
      next: data => this.processData(1 , data),
      error: error => this.processData(0 ,  error)
    });
  }

  processData(hasil: number, data: any): void{
    if(hasil == 0){
      console.error('Error get Kegiatan', data);
      this.spinner.hide();
      Swal.fire(
        'Gagal!',
        'Gagal mendapatkan data.',
        'error'
      );
      return;
    }
    this.thisTahapanKegiatan = new Tahapan_Kegiatan();
    this.thisTahapanKegiatan.setData(data['kegiatan_tahapan']);
    this.thisTahapanKegiatanOriginas = new Tahapan_Kegiatan();
    this.thisTahapanKegiatanOriginas.setData(data['kegiatan_tahapan']);

    this.myData.all_seksi.forEach(element => {
      if(element.id == this.thisTahapanKegiatan.seksi_id){
        this.thisTahapanKegiatan.seksi = element;
      }
      if(element.id == this.thisTahapanKegiatanOriginas.seksi_id){
        this.thisTahapanKegiatanOriginas.seksi = element;
      }
    });
    // console.log(this.thisTahapanKegiatan);
    this.processUsersorMitra(0, data['alluser']);
    this.processUsersorMitra(1, data['allmitra']);

    if (this.isFirst){
      this.spinner.hide();
      this.isFirst = false;
    }
    this.reRenderTable();
  }

  onGoBack(): void {
    this.router.navigate(['/kegiatan/' + this.idKegiatan]);
  }

  processUsersorMitra(statUser: number, data: any ): void{
    if (statUser == 0){
      //user
      this.users = [];
      data.forEach(element => {
        let itemUser = new User();
        itemUser.setData(element);
        this.users.push(itemUser);
      });
    }else if(statUser == 1){
      //mitra
      this.mitras = [];
      data.forEach(element => {
        let itemMitra = new Mitra();
        itemMitra.setData(element);
        this.mitras.push(itemMitra);
      });
    }
  }


  trackByIndex(index: number, obj: any): any {
    return index;
  }
  clean(){
    this.spinner.show();
    this.thisTahapanKegiatan = new Tahapan_Kegiatan();
    this.thisTahapanKegiatan.setData(JSON.parse(JSON.stringify(this.thisTahapanKegiatanOriginas)));
    this.myData.all_seksi.forEach(element => {
      if(element.id == this.thisTahapanKegiatan.seksi_id){
        this.thisTahapanKegiatan.seksi = element;
      }
    });
    this.spinner.hide();
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

  onUbahIndividu(itemCapaianIndividu: Capaian_Individu): void{
   itemCapaianIndividu.isEdit = 1;
  }

  onSubmitUpdateIndividu(itemCapaianIndividu: Capaian_Individu): void{
    this.spinner.show();
    this.myData.updateCapaianIndividu(itemCapaianIndividu).subscribe({
      next: data => this.onSubmitUpdateIndividuProcess(1 , itemCapaianIndividu),
      error: error => this.onSubmitUpdateIndividuProcess(0 ,  itemCapaianIndividu)
    });
  }
  onSubmitUpdateIndividuProcess(hasil: number, itemCapaianEdit: Capaian_Individu){
     if(hasil==0){
      this.thisTahapanKegiatanOriginas.capaianIndividuPairDL.forEach(element => {
        if(element.capaianIndividu.id == itemCapaianEdit.id){
          itemCapaianEdit.realisasi_01 = element.capaianIndividu.realisasi_01;
          itemCapaianEdit.realisasi_02 = element.capaianIndividu.realisasi_02;
          itemCapaianEdit.realisasi_03 = element.capaianIndividu.realisasi_03;
          itemCapaianEdit.realisasi_04 = element.capaianIndividu.realisasi_04;
          itemCapaianEdit.realisasi_05 = element.capaianIndividu.realisasi_05;
          itemCapaianEdit.realisasi_06 = element.capaianIndividu.realisasi_06;
          itemCapaianEdit.realisasi_07 = element.capaianIndividu.realisasi_07;
          itemCapaianEdit.realisasi_08 = element.capaianIndividu.realisasi_08;
          itemCapaianEdit.realisasi_09 = element.capaianIndividu.realisasi_09;
          itemCapaianEdit.realisasi_10 = element.capaianIndividu.realisasi_10;
          itemCapaianEdit.realisasi_11 = element.capaianIndividu.realisasi_11;
          itemCapaianEdit.realisasi_12 = element.capaianIndividu.realisasi_12;
        }
      });
      Swal.fire(
        'Gagal!',
        'Gagal memperbarui realisasi.',
        'error'
      );
     }else if(hasil==1){
      this.thisTahapanKegiatanOriginas.capaianIndividuPairDL.forEach(element => {
        if(element.capaianIndividu.id == itemCapaianEdit.id){
          element.capaianIndividu.realisasi_01 = itemCapaianEdit.realisasi_01;
          element.capaianIndividu.realisasi_02 = itemCapaianEdit.realisasi_02;
          element.capaianIndividu.realisasi_03 = itemCapaianEdit.realisasi_03;
          element.capaianIndividu.realisasi_04 = itemCapaianEdit.realisasi_04;
          element.capaianIndividu.realisasi_05 = itemCapaianEdit.realisasi_05;
          element.capaianIndividu.realisasi_06 = itemCapaianEdit.realisasi_06;
          element.capaianIndividu.realisasi_07 = itemCapaianEdit.realisasi_07;
          element.capaianIndividu.realisasi_08 = itemCapaianEdit.realisasi_08;
          element.capaianIndividu.realisasi_09 = itemCapaianEdit.realisasi_09;
          element.capaianIndividu.realisasi_10 = itemCapaianEdit.realisasi_10;
          element.capaianIndividu.realisasi_11 = itemCapaianEdit.realisasi_11;
          element.capaianIndividu.realisasi_12 = itemCapaianEdit.realisasi_12;
        }
      });
      Swal.fire(
        'Berhasil!',
        'Berhasil memperbarui realisasi.',
        'success'
      );
     }
     itemCapaianEdit.isEdit = 0;
     this.reRenderTable();
   }

  onUbahtahapan(): void{
    this.thisTahapanKegiatan.capaian_tahapan.isEdit = 1;
  }

  onSubmitUpdateTahapan(): void{
    this.spinner.show();
    this.myData.updateCapaianTahapan(this.thisTahapanKegiatan.capaian_tahapan).subscribe({
      next: data => this.onSubmitUpdateeTahapanProcess(1),
      error: error => this.onSubmitUpdateeTahapanProcess(0)
    });
  }
  onSubmitUpdateeTahapanProcess(hasil: number){
     if(hasil==0){
          this.thisTahapanKegiatan.capaian_tahapan.realisasi_01 = this.thisTahapanKegiatanOriginas.capaian_tahapan.realisasi_01;
          this.thisTahapanKegiatan.capaian_tahapan.realisasi_02 = this.thisTahapanKegiatanOriginas.capaian_tahapan.realisasi_02;
          this.thisTahapanKegiatan.capaian_tahapan.realisasi_03 = this.thisTahapanKegiatanOriginas.capaian_tahapan.realisasi_03;
          this.thisTahapanKegiatan.capaian_tahapan.realisasi_04 = this.thisTahapanKegiatanOriginas.capaian_tahapan.realisasi_04;
          this.thisTahapanKegiatan.capaian_tahapan.realisasi_05 = this.thisTahapanKegiatanOriginas.capaian_tahapan.realisasi_05;
          this.thisTahapanKegiatan.capaian_tahapan.realisasi_06 = this.thisTahapanKegiatanOriginas.capaian_tahapan.realisasi_06;
          this.thisTahapanKegiatan.capaian_tahapan.realisasi_07 = this.thisTahapanKegiatanOriginas.capaian_tahapan.realisasi_07;
          this.thisTahapanKegiatan.capaian_tahapan.realisasi_08 = this.thisTahapanKegiatanOriginas.capaian_tahapan.realisasi_08;
          this.thisTahapanKegiatan.capaian_tahapan.realisasi_09 = this.thisTahapanKegiatanOriginas.capaian_tahapan.realisasi_09;
          this.thisTahapanKegiatan.capaian_tahapan.realisasi_10 = this.thisTahapanKegiatanOriginas.capaian_tahapan.realisasi_10;
          this.thisTahapanKegiatan.capaian_tahapan.realisasi_11 = this.thisTahapanKegiatanOriginas.capaian_tahapan.realisasi_11;
          this.thisTahapanKegiatan.capaian_tahapan.realisasi_12 = this.thisTahapanKegiatanOriginas.capaian_tahapan.realisasi_12;
          Swal.fire(
            'Gagal!',
            'Gagal memperbarui realisasi.',
            'error'
          );
     }else if(hasil==1){
          this.thisTahapanKegiatanOriginas.capaian_tahapan.realisasi_01 = this.thisTahapanKegiatan.capaian_tahapan.realisasi_01;
          this.thisTahapanKegiatanOriginas.capaian_tahapan.realisasi_02 = this.thisTahapanKegiatan.capaian_tahapan.realisasi_02;
          this.thisTahapanKegiatanOriginas.capaian_tahapan.realisasi_03 = this.thisTahapanKegiatan.capaian_tahapan.realisasi_03;
          this.thisTahapanKegiatanOriginas.capaian_tahapan.realisasi_04 = this.thisTahapanKegiatan.capaian_tahapan.realisasi_04;
          this.thisTahapanKegiatanOriginas.capaian_tahapan.realisasi_05 = this.thisTahapanKegiatan.capaian_tahapan.realisasi_05;
          this.thisTahapanKegiatanOriginas.capaian_tahapan.realisasi_06 = this.thisTahapanKegiatan.capaian_tahapan.realisasi_06;
          this.thisTahapanKegiatanOriginas.capaian_tahapan.realisasi_07 = this.thisTahapanKegiatan.capaian_tahapan.realisasi_07;
          this.thisTahapanKegiatanOriginas.capaian_tahapan.realisasi_08 = this.thisTahapanKegiatan.capaian_tahapan.realisasi_08;
          this.thisTahapanKegiatanOriginas.capaian_tahapan.realisasi_09 = this.thisTahapanKegiatan.capaian_tahapan.realisasi_09;
          this.thisTahapanKegiatanOriginas.capaian_tahapan.realisasi_10 = this.thisTahapanKegiatan.capaian_tahapan.realisasi_10;
          this.thisTahapanKegiatanOriginas.capaian_tahapan.realisasi_11 = this.thisTahapanKegiatan.capaian_tahapan.realisasi_11;
          this.thisTahapanKegiatanOriginas.capaian_tahapan.realisasi_12 = this.thisTahapanKegiatan.capaian_tahapan.realisasi_12;
          Swal.fire(
            'Berhasil!',
            'Berhasil memperbarui realisasi.',
            'success'
          );
     }
     this.thisTahapanKegiatan.capaian_tahapan.isEdit = 0;
     this.reRenderTable();
   }

  getNamaPelaksana(type: string, id: string){
    if(type == '0'){
      return this.users.filter(item=> item.nip_lama == id)[0]
    }else if(type == '1'){
      return this.mitras.filter(item=>item.id == id)[0];
    }
  }
  getTergetBulan(capaianIndividu: Capaian_Individu): number {
    return capaianIndividu.getTergetBulan(parseInt(this.bulan_index.toString()));
  }
  getRealisasiBulan(capaianIndividu: Capaian_Individu): number {
    return capaianIndividu.getRealisasiBulan(parseInt(this.bulan_index.toString()));
  }
  getTergetBulanTahapan(): number {
    return this.thisTahapanKegiatan.capaian_tahapan.getTergetBulan(parseInt(this.bulan_index.toString()));
  }
  getRealisasiBulanTahapan(): number {
    return this.thisTahapanKegiatan.capaian_tahapan.getRealisasiBulan(parseInt(this.bulan_index.toString()));
  }

}
