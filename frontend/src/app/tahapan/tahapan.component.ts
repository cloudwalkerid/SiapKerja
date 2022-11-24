import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { MyDataService } from '../my-data.service';
import { Kegiatan, User, Mitra, Tahapan_Kegiatan, Capaian_Tahapan, Capaian_Individu, Tahapan_Alokasi_DL, Capaian_Individu_Pair_DL } from '../Object/Object';
import { NgxSpinnerService } from 'ngx-spinner';
import { Location } from '@angular/common';
import Swal from 'sweetalert2';

declare var $: any;

@Component({
  selector: 'app-tahapan',
  templateUrl: './tahapan.component.html',
  styleUrls: ['./tahapan.component.css']
})
export class TahapanComponent implements OnInit {

  idKegiatan: string;
  idTahapan: string;

  thisTahapanKegiatan: Tahapan_Kegiatan;
  editahapanKegiatan: Tahapan_Kegiatan;
  isFirst: boolean = true;

  users: User[];
  mitras: Mitra[];

  bulan_nama: string[] = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'
                  , 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

  bulan_nama_aktive: string[] = [];

  see_bulan: boolean[] = [false, false, false, false, false, false
    , false, false, false, false, false, false]



  constructor(public myData: MyDataService, private route: ActivatedRoute, private router: Router
    ,private spinner: NgxSpinnerService, private location: Location) {
      this.spinner.show();
    }

  ngOnInit(): void {
    this.route.params.subscribe(routeParams => {
      this.isFirst = true;
      this.spinner.show();
      this.thisTahapanKegiatan = new Tahapan_Kegiatan();
      this.editahapanKegiatan = new Tahapan_Kegiatan();

      this.idKegiatan = this.route.snapshot.paramMap.get('id');
      this.idTahapan = this.route.snapshot.paramMap.get('idtahapan');

      this.users = [];
      this.mitras = [];

      this.loadDataTahapanKegiatan(this.idKegiatan, this.idTahapan);
      // let minuteCounter = interval(60 * 1000);
      // minuteCounter.subscribe(n =>
      //   this.loadDataTahapanKegiatan(this.idKegiatan, this.idTahapan));
      });
      $(
        function() {
          $("#startDate").datepicker( {dateFormat : "dd-mm-yy"});
          $("#endDate").datepicker( {dateFormat : "dd-mm-yy"});
        }
      );
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

    this.editahapanKegiatan.nama = this.thisTahapanKegiatan.nama;
    this.editahapanKegiatan.satuan = this.thisTahapanKegiatan.satuan;
    this.editahapanKegiatan.awal = this.thisTahapanKegiatan.awal;
    this.editahapanKegiatan.akhir = this.thisTahapanKegiatan.akhir;
    this.editahapanKegiatan.id = this.thisTahapanKegiatan.id;
    this.editahapanKegiatan.kegiatan_id = this.thisTahapanKegiatan.kegiatan_id;

    (<HTMLInputElement>document.getElementById('startDate')).value = this.thisTahapanKegiatan.awal;
    (<HTMLInputElement>document.getElementById('endDate')).value = this.thisTahapanKegiatan.akhir;

    this.myData.all_seksi.forEach(element => {
      if(element.id == this.thisTahapanKegiatan.seksi_id){
        this.thisTahapanKegiatan.seksi = element;
      }
    });
    this.processUsersorMitra(0, data['alluser']);
    this.processUsersorMitra(1, data['allmitra']);
    this.columnVisible();

    this.bulan_nama_aktive = this.bulan_nama.slice((this.thisTahapanKegiatan.bulan_awal-1), this.thisTahapanKegiatan.bulan_akhir);
    if (this.isFirst){
      this.spinner.hide();
      this.isFirst = false;
    }
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

  onEditTahapan(): void{
    this.editahapanKegiatan.awal = (<HTMLInputElement>document.getElementById('startDate')).value;
    this.editahapanKegiatan.akhir = (<HTMLInputElement>document.getElementById('endDate')).value;
    if(this.editahapanKegiatan.awal == '' || this.editahapanKegiatan.akhir == ''){
      return;
    }
    this.spinner.show();
    this.myData.updateTahapanKegiatan(this.editahapanKegiatan).subscribe({
      next: data => this.procesEditTahapan(1, data),
      error: error => this.procesEditTahapan(0, error)
    });
  }
  procesEditTahapan(hasil: number, data: string): void{
    this.spinner.hide();
    if (hasil === 1){
      this.thisTahapanKegiatan.nama = this.editahapanKegiatan.nama;
      this.thisTahapanKegiatan.satuan = this.editahapanKegiatan.satuan;
      this.thisTahapanKegiatan.awal = this.editahapanKegiatan.awal;
      this.thisTahapanKegiatan.akhir = this.editahapanKegiatan.akhir;
      this.thisTahapanKegiatan.bulan_awal = parseInt(this.editahapanKegiatan.awal.split('-')[1])
      this.thisTahapanKegiatan.bulan_akhir = parseInt(this.editahapanKegiatan.akhir.split('-')[1])
      this.bulan_nama_aktive = this.bulan_nama.slice((this.thisTahapanKegiatan.bulan_awal-1), this.thisTahapanKegiatan.bulan_akhir);
      Swal.fire(
        'Berhasil!',
        'Kegiatan tahapan berhasil diubah.',
        'success'
      );
    }else if (hasil === 0){
      this.editahapanKegiatan.nama = this.thisTahapanKegiatan.nama;
      this.editahapanKegiatan.satuan = this.thisTahapanKegiatan.satuan;
      this.editahapanKegiatan.awal = this.thisTahapanKegiatan.awal;
      this.editahapanKegiatan.akhir = this.thisTahapanKegiatan.akhir;
      (<HTMLInputElement>document.getElementById('startDate')).value = this.thisTahapanKegiatan.awal;
      (<HTMLInputElement>document.getElementById('endDate')).value = this.thisTahapanKegiatan.akhir;
      console.error('Error get referensi', data);
      Swal.fire(
        'Gagal!',
        'Kegiatan tahapan gagal diubah.',
        'error'
      );
    }
    document.getElementById('closeEditTahapanKegiatan').click();
  }

  onDeleteTahapan(): void{
    Swal.fire({
      title: 'Hapus tahapan kegiatan ' + this.thisTahapanKegiatan.nama + '?',
      showCancelButton: true,
      confirmButtonText: `Hapus`,
      cancelButtonText: `Tutup`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        this.spinner.show();
        this.myData.deleteTahapanKegiatan(this.thisTahapanKegiatan).subscribe({
          next: data => this.procesDeleteTahapan(1),
          error: error => this.procesDeleteTahapan(0)
        });
      }
    });
  }
  procesDeleteTahapan(hasil: number): void{
    this.spinner.hide();
    if (hasil == 1){
      Swal.fire(
        'Berhasil!',
        'Tahapan Kegiatan berhasil dihapus.',
        'success'
      );
      this.location.replaceState('/');
      this.router.navigate(['/kegiatan/'+this.idKegiatan]);
    }else if ( hasil == 0){
      Swal.fire(
        'Gagal!',
        'Tahapan Kegiatan gagal dihapus.',
        'error'
      );
    }
  }

  columnVisible(){
    // console.log( this.thisTahapanKegiatan);
    for (let i = 0; i < 12; i++){
      if ( this.thisTahapanKegiatan.bulan_awal <= (i+1) && (i+1) <= this.thisTahapanKegiatan.bulan_akhir){
        this.see_bulan[i] = true;
      }else{
        this.see_bulan[i] = false;
      }
    }
   
  }

  onChangeSomething(): void{
    if (this.thisTahapanKegiatan.yang_isi == '0'){
      this.thisTahapanKegiatan.capaian_tahapan.target_all = this.thisTahapanKegiatan.capaian_tahapan.getTargetAll();
    }else if (this.thisTahapanKegiatan.yang_isi == '1'){
      // console.log("change somthing");
      let target_01 = 0;
      let target_02 = 0;
      let target_03 = 0;
      let target_04 = 0;
      let target_05 = 0;
      let target_06 = 0;
      let target_07 = 0;
      let target_08 = 0;
      let target_09 = 0;
      let target_10 = 0;
      let target_11 = 0;
      let target_12 = 0;
      let target_all = 0;
      this.thisTahapanKegiatan.capaianIndividuPairDL.forEach(element => {
          target_01 = target_01 + element.capaianIndividu.target_01;
          target_02 = target_02 + element.capaianIndividu.target_02;
          target_03 = target_03 + element.capaianIndividu.target_03;
          target_04 = target_04 + element.capaianIndividu.target_04;
          target_05 = target_05 + element.capaianIndividu.target_05;
          target_06 = target_06 + element.capaianIndividu.target_06;
          target_07 = target_07 + element.capaianIndividu.target_07;
          target_08 = target_08 + element.capaianIndividu.target_08;
          target_09 = target_09 + element.capaianIndividu.target_09;
          target_10 = target_10 + element.capaianIndividu.target_10;
          target_11 = target_11 + element.capaianIndividu.target_11;
          target_12 = target_12 + element.capaianIndividu.target_12;
          element.capaianIndividu.setTargetAll();
          target_all = target_all + element.capaianIndividu.target_all;
      });
      this.thisTahapanKegiatan.capaian_tahapan.target_01 = target_01;
      this.thisTahapanKegiatan.capaian_tahapan.target_02 = target_02;
      this.thisTahapanKegiatan.capaian_tahapan.target_03 = target_03;
      this.thisTahapanKegiatan.capaian_tahapan.target_04 = target_04;
      this.thisTahapanKegiatan.capaian_tahapan.target_05 = target_05;
      this.thisTahapanKegiatan.capaian_tahapan.target_06 = target_06;
      this.thisTahapanKegiatan.capaian_tahapan.target_07 = target_07;
      this.thisTahapanKegiatan.capaian_tahapan.target_08 = target_08;
      this.thisTahapanKegiatan.capaian_tahapan.target_09 = target_09;
      this.thisTahapanKegiatan.capaian_tahapan.target_10 = target_10;
      this.thisTahapanKegiatan.capaian_tahapan.target_11 = target_11;
      this.thisTahapanKegiatan.capaian_tahapan.target_12 = target_12;
      this.thisTahapanKegiatan.capaian_tahapan.target_all = target_all;
      // console.log(this.thisTahapanKegiatan);
    }
  }

  trackByIndex(index: number, obj: any): any {
    return index;
  }

  tambahPairCapaianIndividuDL(): void{
    if(this.thisTahapanKegiatan.capaianIndividuPairDL == null){
      this.thisTahapanKegiatan.capaianIndividuPairDL = [];
    }
    let newCapaianIndividu = new Capaian_Individu();
    newCapaianIndividu.kegiatan_id = this.thisTahapanKegiatan.kegiatan_id;
    newCapaianIndividu.capaian_tahapan_id = this.thisTahapanKegiatan.id;
    newCapaianIndividu.target_01 = 0;
    newCapaianIndividu.target_02 = 0;
    newCapaianIndividu.target_03 = 0;
    newCapaianIndividu.target_04 = 0;
    newCapaianIndividu.target_05 = 0;
    newCapaianIndividu.target_06 = 0;
    newCapaianIndividu.target_07 = 0;
    newCapaianIndividu.target_08 = 0;
    newCapaianIndividu.target_09 = 0;
    newCapaianIndividu.target_10 = 0;
    newCapaianIndividu.target_11 = 0;
    newCapaianIndividu.target_12 = 0;
    newCapaianIndividu.target_all = 0;

    let alokasi_dl = new Tahapan_Alokasi_DL();
    alokasi_dl.kegiatan_id = this.thisTahapanKegiatan.kegiatan_id;
    alokasi_dl.kegiatan_tahapan_id = this.thisTahapanKegiatan.id;
    alokasi_dl.jumlah_dl = 0;

    let itemPair = new Capaian_Individu_Pair_DL();
    itemPair.capaianIndividu = newCapaianIndividu;
    itemPair.alokasi_dl = alokasi_dl;
    itemPair.status_user = '0';
    itemPair.status_ubah = '1';
    // console.log(itemPair);
    this.thisTahapanKegiatan.capaianIndividuPairDL.push(itemPair);
    console.log(this.thisTahapanKegiatan.capaianIndividuPairDL);
  }

  deletePair(indexDelete: number): void{
    if (this.thisTahapanKegiatan.capaianIndividuPairDL[indexDelete].capaianIndividu.id == null){
      let arrayCapaianDLPairBaru: Capaian_Individu_Pair_DL[] = [];
      this.thisTahapanKegiatan.capaianIndividuPairDL.forEach( (element, index) => {
        if(index != indexDelete){
          arrayCapaianDLPairBaru.push(element);
        }
      });
      this.thisTahapanKegiatan.capaianIndividuPairDL = arrayCapaianDLPairBaru;
    }else if(this.thisTahapanKegiatan.capaianIndividuPairDL[indexDelete].capaianIndividu.id == ''){
      let arrayCapaianDLPairBaru: Capaian_Individu_Pair_DL[] = [];
      this.thisTahapanKegiatan.capaianIndividuPairDL.forEach( (element, index) => {
        if(index != indexDelete){
          arrayCapaianDLPairBaru.push(element);
        }
      });
      this.thisTahapanKegiatan.capaianIndividuPairDL = arrayCapaianDLPairBaru;
    }else{
      let itemDeletePait: Capaian_Individu_Pair_DL = this.thisTahapanKegiatan.capaianIndividuPairDL[indexDelete];
      itemDeletePait.status_ubah = '2';
      this.thisTahapanKegiatan.deletedCapaianIndividuPairDL.push(itemDeletePait);
      let arrayCapaianDLPairBaru: Capaian_Individu_Pair_DL[] = [];
      this.thisTahapanKegiatan.capaianIndividuPairDL.forEach( (element, index) => {
        if(index != indexDelete){
          arrayCapaianDLPairBaru.push(element);
        }
      });
      this.thisTahapanKegiatan.capaianIndividuPairDL = arrayCapaianDLPairBaru;
    }
    // itemPair.status_ubah = '2';
  }

  submitAlokasi(): void{
    console.log(this.thisTahapanKegiatan);
    if (this.thisTahapanKegiatan.yang_isi == '1'){
      let isError: boolean = false;
      let errorMessage: string = '';
      this.thisTahapanKegiatan.capaianIndividuPairDL.forEach( (element, index) => {
        if ((element.status_user=='0' && element.nip_lama == '') || 
            ( element.status_user=='1' && element.mitra_id == '' && element.mitra_nama == '')){
          isError = true;
          errorMessage = 'Pelaksana harus terisi';
        }
        if (element.capaianIndividu.tujuan == null || element.capaianIndividu.tujuan == ''){
          isError = true;
          errorMessage = 'Tujuan harus terisi';
        }
        if (!element.capaianIndividu.checkNoMinus()){
          isError = true;
          errorMessage = 'Terdapat target dengan nilai minus';
        }
      });
      if (isError) {
        Swal.fire(
          'Error!',
          'Gagal memperbarui alokasi. ' + errorMessage + '.',
          'error'
        );
        return;
      }
    }
    this.isFirst = true;
    if(!this.thisTahapanKegiatan.capaian_tahapan.checkNoMinus()){
      Swal.fire(
        'Error!',
        'Gagal memperbarui alokasi. Terdapat target dengan nilai minus.',
        'error'
      );
      return;
    }
    this.spinner.show();
    this.myData.tahapanAlokasiKegiatan(this.thisTahapanKegiatan).subscribe({
      next: data => this.submitAlokasiProcess(1),
      error: error => this.submitAlokasiProcess(0)
    });
  }
  submitAlokasiProcess(hasil: number): void{
    if (hasil==1){
      Swal.fire(
        'Berhasil!',
        'Berhasil memperbarui alokasi.',
        'success'
      );
      this.loadDataTahapanKegiatan(this.idKegiatan, this.idTahapan);
    }else if(hasil==0){
      this.spinner.hide();
      Swal.fire(
        'Gagal!',
        'Gagal memperbarui alokasi.',
        'error'
      );
    }
  }
}
