import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { MyDataService } from '../my-data.service';
import { Kegiatan, User, Mitra, Kegiatan_PJ, Tahapan_Kegiatan, Ref_Tahapan } from '../Object/Object';
import { interval } from 'rxjs';
import { NgxSpinnerService } from 'ngx-spinner';
import { Location } from '@angular/common';
import Swal from 'sweetalert2';
import {NgForm} from '@angular/forms'

declare var $: any;
declare var Cleave: any;

@Component({
  selector: 'app-kegiatan',
  templateUrl: './kegiatan.component.html',
  styleUrls: ['./kegiatan.component.css']
})
export class KegiatanComponent implements OnInit {

  idKegiatan: string;
  thisKegiatan: Kegiatan;
  isFirst: boolean = true;
  users: User[]; 
  mitras: Mitra[];
  referensi: Ref_Tahapan[];
  newPJ: Kegiatan_PJ;
  newTahapan: Tahapan_Kegiatan;
  
  editKegiatan: Kegiatan;
  show = true;

  constructor(public myData: MyDataService, private route: ActivatedRoute, private router: Router
    ,private spinner: NgxSpinnerService, private location: Location) {
      this.spinner.show();
   }

  ngOnInit(): void {
    this.route.params.subscribe(routeParams => {
      this.isFirst = true;
      this.spinner.show();
      this.thisKegiatan = new Kegiatan();
      this.newPJ = new Kegiatan_PJ();
      this.newTahapan = new Tahapan_Kegiatan();
      this.editKegiatan = new Kegiatan();
      this.idKegiatan = this.route.snapshot.paramMap.get('id');
      this.newPJ.kegiatan_id = this.idKegiatan;
      this.newTahapan.kegiatan_id = this.idKegiatan;
      // console.log(this.idKegiatan);
      this.loadDataKegiatan(this.idKegiatan);
      let minuteCounter = interval(15 * 60 * 1000);
      minuteCounter.subscribe(n =>
        this.loadDataKegiatan(this.idKegiatan));
    });

    $(
      function() {
        $("#startDate").datepicker( {dateFormat : "dd-mm-yy"});
        $("#endDate").datepicker( {dateFormat : "dd-mm-yy"});
      }
    );
    $(
      function() {
        var cleaveC = new Cleave('.currency', {
          numeral: true,
          numeralThousandsGroupStyle: 'thousand'
        });
      }
    );
    
  }

  loadDataKegiatan(idKegiatan: string): void{
    this.myData.getKegiatan(idKegiatan).subscribe({
      next: data => this.processData(data),
      error: error => console.error('Error get Kegiatan', error)
    });
  }

  processData(data: any): void{
    if(this.isFirst){
      this.spinner.hide();
      this.isFirst = false;
    }
    this.thisKegiatan = new Kegiatan();
    this.thisKegiatan.setData(data);
    this.myData.all_seksi.forEach(element => {
      if(element.id == this.thisKegiatan.seksi_id){
        this.thisKegiatan.seksi = element;
      }
    });
    console.log(this.thisKegiatan);
    this.editKegiatan.id = this.thisKegiatan.id;
    this.editKegiatan.nama = this.thisKegiatan.nama;
    this.editKegiatan.anggaran = this.thisKegiatan.anggaran;
    this.editKegiatan.anggaran_text = this.thisKegiatan.anggaran.toString();

    (<HTMLInputElement>document.getElementById('editkegiatan_anggaran')).value = this.thisKegiatan.anggaran_text;
    let event = new Event('input');
    document.getElementById('editkegiatan_anggaran').dispatchEvent(event);
    this.reRenderTable();
  }

  loadDataUser(): void {
    this.myData.getUser().subscribe({
      next: data => this.processUsersorMitra(0, data),
      error: error => console.error('Error get Kegiatan', error)
    });
  }
  processUsersorMitra(statUser: number, data: any ): void{
    if(statUser == 0){
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
  onSubmitnewPJ(): void{
    this.spinner.show();
    this.myData.addNewPJ(this.newPJ).subscribe({
      next: data => this.addPJSuccesFail(1, data),
      error: error => this.addPJSuccesFail(0, null)
    });
  }
  addPJSuccesFail(hasil: number, data: string): void{
    this.spinner.hide();
    if (hasil === 1){
      this.newPJ.id = data;
      let newPJadd = new Kegiatan_PJ();
      newPJadd.id = data;
      newPJadd.kegiatan_id = this.thisKegiatan.id;
      newPJadd.nip_lama = this.newPJ.nip_lama;
      this.users.forEach(element => {
        if(element.nip_lama == newPJadd.nip_lama){
          newPJadd.user = element;
        }
      });
      this.thisKegiatan.p_j.push(newPJadd);
      this.newPJ = new Kegiatan_PJ();
      this.newPJ.kegiatan_id = this.thisKegiatan.id;
      Swal.fire(
        'Berhasil!',
        'Kegiatan PJ baru berhasil ditambahkan.',
        'success'
      );
      this.reRenderTable();
    }else if (hasil === 0){
      Swal.fire(
        'Gagal!',
        'Kegiatan PJ baru gagal ditambahkan.',
        'error'
      );
    }
    document.getElementById('closeAddPJKegiatan').click();
  }

  deletePJ(index: number, deleteItemPJ: Kegiatan_PJ): void{
    this.spinner.show();
    this.myData.deletePJ(deleteItemPJ).subscribe({
      next: data => this.deletePJSuccesFail(1, index, deleteItemPJ),
      error: error => this.deletePJSuccesFail(0, 0, null)
    });
  }
  deletePJSuccesFail(hasil: number, indexDelete: number,  deletedPJ: Kegiatan_PJ): void{
    this.spinner.hide();
    if (hasil === 1){
      this.thisKegiatan.p_j = this.thisKegiatan.p_j.filter(item => item.id != deletedPJ.id);
      // console.log(this.thisKegiatan.p_j);
      Swal.fire(
        'Berhasil!',
        'Kegiatan PJ berhasil dihapus.',
        'success'
      );
      this.reRenderTable();
    }else if (hasil === 0){
      Swal.fire(
        'Gagal!',
        'Kegiatan PJ gagal dihapus.',
        'error'
      );
    }
  }

  loadDataRefensi(): void {
    this.myData.getDataReferensi().subscribe({
      next: data => this.processdataRef(data),
      error: error => console.error('Error get referensi', error)
    });
  }

  processdataRef(data: any ): void{
    this.referensi = [];
    data.forEach(element => {
      let itemRef = new Ref_Tahapan();
      itemRef.setData(element);
      this.referensi.push(itemRef);
    });
    console.log(this.referensi);
  }
  onSubmitnewTahapan(newTahpanForm: NgForm): void{
    this.newTahapan.awal = (<HTMLInputElement>document.getElementById('startDate')).value;
    this.newTahapan.akhir = (<HTMLInputElement>document.getElementById('endDate')).value;
    if(this.newTahapan.awal == '' || this.newTahapan.akhir == ''){
      return;
    }
    console.log(this.newTahapan);
    this.spinner.show();
    // console.log(this.newTahapan);
    this.myData.createTahapanKegiatan(this.newTahapan).subscribe({
      next: data => this.processDataTahapanBaru(1, data, newTahpanForm),
      error: error => this.processDataTahapanBaru(0, error, newTahpanForm)
    });
  }
  processDataTahapanBaru(hasil: number, data: any, newTahpanForm: NgForm): void{
    this.spinner.hide();
    if (hasil === 1){
      let itemTahapan = new Tahapan_Kegiatan();
      itemTahapan.setData(data);
      this.thisKegiatan.kegiatan_tahapan.push(itemTahapan);
      Swal.fire(
        'Berhasil!',
        'Kegiatan tahapan berhasil dibuat.',
        'success'
      );
      newTahpanForm.resetForm();
      // this.newTahapan = new Tahapan_Kegiatan();
      // this.newTahapan.kegiatan_id = this.idKegiatan;
      this.reRenderTable();
    }else if (hasil === 0){
      // console.error('Error get referensi', data);
      Swal.fire(
        'Gagal!',
        'Kegiatan tahapan gagal dibuat.',
        'error'
      );
    }
    document.getElementById('closeAddKegiatanTahapan').click();
  }
  editKegiatanA(){
    this.spinner.show();
    this.editKegiatan.anggaran = parseInt(this.editKegiatan.anggaran_text.replace(/\./g,'').replace(/,/g,''))
    this.myData.updateKegiatan(this.editKegiatan).subscribe({
      next: data => this.editKegiatanProcess(1),
      error: error => this.editKegiatanProcess(0)
    });
  }
  editKegiatanProcess(hasil: number): void{
    this.spinner.hide();
    if(hasil == 1){
      Swal.fire(
        'Berhasil!',
        'Kegiatan berhasil diperbarui.',
        'success'
      );
      this.myData.myKegiatan.forEach(element => {
        if(element.id == this.editKegiatan.id){
          element.nama = this.editKegiatan.nama;
          element.anggaran = this.editKegiatan.anggaran;
          element.anggaran_text = this.editKegiatan.anggaran_text;
        }
      });
      this.thisKegiatan.nama = this.editKegiatan.nama;
      this.thisKegiatan.anggaran = this.editKegiatan.anggaran;
      this.thisKegiatan.anggaran_text = this.editKegiatan.anggaran_text;
    }else if(hasil == 0){
      Swal.fire(
        'Gagal!',
        'Kegiatan gagal diperbarui.',
        'error'
      );
    }
    document.getElementById('closeEditKegiatan').click();
  }
  deleteKegiatanA(): void{
    Swal.fire({
      title: 'Hapus kegiatan ' + this.thisKegiatan.nama + '?',
      showCancelButton: true,
      confirmButtonText: `Hapus`,
      cancelButtonText: `Tutup`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        this.spinner.show();
        this.myData.deleteKegiatan(this.editKegiatan).subscribe({
          next: data => this.deleteKegiatanProcess(1),
          error: error => this.deleteKegiatanProcess(0)
        });
      }
    });
  }
  deleteKegiatanProcess(hasil: number): void{
    this.spinner.hide();
    if(hasil == 1){
      Swal.fire(
        'Berhasil!',
        'Kegiatan berhasil dihapus.',
        'success'
      );
      this.myData.myKegiatan = this.myData.myKegiatan.filter(item => item.id != this.editKegiatan.id);
      this.location.replaceState('/');
      this.router.navigate(['/home']);
    }else if(hasil == 0){
      Swal.fire(
        'Gagal!',
        'Kegiatan gagal dihapus.',
        'error'
      );
    }
  }

  startTahapanKegiatan(itemTahapan: Tahapan_Kegiatan): void{
    Swal.fire({
      title: 'Mulai tahapan kegiatan ' + itemTahapan.nama + '?',
      showCancelButton: true,
      confirmButtonText: `Mulai`,
      cancelButtonText: `Tutup`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        this.spinner.show();
        this.myData.startTahapanKegiatan(itemTahapan).subscribe({
          next: data => this.startTahapanKegiatanProcess(1, itemTahapan),
          error: error => this.startTahapanKegiatanProcess(0, itemTahapan)
        });
      }
    });
  }
  startTahapanKegiatanProcess(hasil: number, itemTahapan: Tahapan_Kegiatan): void{
    this.spinner.hide();
    if(hasil == 1){
      Swal.fire(
        'Berhasil!',
        'Tahapan berhasil dimulai.',
        'success'
      );
      itemTahapan.is_mulai = '1';
      this.reRenderTable();
    }else if(hasil == 0){
      Swal.fire(
        'Gagal!',
        'Kegiatan gagal dihapus.',
        'error'
      );
    }
  }
  stopTahapanKegiatan(itemTahapan: Tahapan_Kegiatan): void{
    Swal.fire({
      title: 'Stop tahpan kegiatan ' + itemTahapan.nama + '?',
      showCancelButton: true,
      confirmButtonText: `Stop`,
      cancelButtonText: `Tutup`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        this.spinner.show();
        this.myData.stopTahapanKegiatan(itemTahapan).subscribe({
          next: data => this.stopTahapanKegiatanProcess(itemTahapan, 1),
          error: error => this.stopTahapanKegiatanProcess(itemTahapan, 0)
        });
      }
    });
  }
  stopTahapanKegiatanProcess(itemTahapan: Tahapan_Kegiatan,  hasil: number): void{
    this.spinner.hide();
    if(hasil == 1){
      Swal.fire(
        'Berhasil!',
        'Tahapan berhasil distop.',
        'success'
      );
      itemTahapan.is_mulai = '0';
      this.reRenderTable();
    }else if(hasil == 0){
      Swal.fire(
        'Gagal!',
        'Tahapan gagal distop.',
        'error'
      );
    }
  }
  seeDetailTahapanKegiatan(itemTahapan: Tahapan_Kegiatan): void{
    this.router.navigate(['kegiatan/' + itemTahapan.kegiatan_id + '/tahapan/' + itemTahapan.id + '/show']);
  }
  seeDetailTahapanCapaianKegiatan(itemTahapan: Tahapan_Kegiatan): void{
    this.router.navigate(['kegiatan/' + itemTahapan.kegiatan_id + '/tahapan/' + itemTahapan.id + '/capaian/show']);
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
}
