import { Component, OnInit } from '@angular/core';
import { MyDataService } from '../my-data.service';
import { Capaian_Individu, Kegiatan, CKP, CKP_Item, User } from '../Object/Object';
import { NgxSpinnerService } from 'ngx-spinner';
import Swal from 'sweetalert2';



declare var $: any;

@Component({
  selector: 'app-ckp',
  templateUrl: './ckp.component.html',
  styleUrls: ['./ckp.component.css']
})
export class CKPComponent implements OnInit {

  capainIndividuCalon: Capaian_Individu[];
  thisCKP: CKP;
  thisCKPOri: CKP;
  statusBulanIni = 0; // 0: bulan buat ckp-t; 1: ckp-t sudah buat belum diupload 2: ckp-t sudah dibuat; 3: ckp-r sudah di submit;
  show = true;
  newCKPTargetItem: CKP_Item[];
  bulan_aktive: number = 0;
  tahun_aktive: number = 0;
  bulan_list = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus'
  , 'September', 'Oktober', 'November', 'Desember'];

  thisCKP_bulan_lalu: CKP;
  users: User[];
  nip_lama: string;
  typeSubmit: number = 0;

  constructor(public myData: MyDataService, private spinner: NgxSpinnerService) {
    this.bulan_aktive = myData.bulan_aktive;
    this.tahun_aktive = myData.tahun_aktive;
    this.spinner.show();
    this.loadDataCKP(this.bulan_aktive, this.tahun_aktive);
  }

  ngOnInit(): void {
    this.spinner.show();
  }

  changeMonth(): void{
    let bulan_nilai = parseInt(this.bulan_aktive.toString());
    this.bulan_aktive = bulan_nilai;
    this.loadDataCKP(bulan_nilai, this.tahun_aktive);
  }

  loadDataCKP(month: number, year: number): void{
    this.spinner.show();
    this.myData.getCKP(month, year).subscribe({
      next: data => this.processData(data),
      error: error => console.error('Error get Kegiatan', error)
    });
  }

  processData(data: any): void{
    this.capainIndividuCalon = [];
    this.thisCKP = new CKP();
    this.thisCKPOri  = new CKP();
    this.newCKPTargetItem = [];
    this.thisCKP_bulan_lalu = new CKP();

    this.statusBulanIni = 0;
    if(data['ckp'] != null){
      this.thisCKP.setData(data['ckp']);
      this.thisCKPOri.setData(data['ckp']);
      console.log(this.thisCKP);
      this.show = true;
      if (this.thisCKP.status == '0'){
        this.statusBulanIni = 2;
      }else if (this.thisCKP.status == '1'){
        this.statusBulanIni = 3;
      }
    }else{
      this.statusBulanIni = 0;
      this.show = false;
    }
    data['capaian_individu'].forEach(element => {
      let itemKegiatan = new Capaian_Individu();
      itemKegiatan.setData(element);
      this.capainIndividuCalon.push(itemKegiatan);
    });
    this.spinner.hide();
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
  processUsersorMitra(stat: number, data: any ): void{
    this.users = [];
    data.forEach(element => {
      let itemUser = new User();
      itemUser.setData(element);
      this.users.push(itemUser);
    });
    this.users = this.users.filter(item=>item.is_kasi_plt == '1');
    if(stat == 0){
      //target
      $(
        function() {
          $('#pilihUserCKPT').modal();
        }
      );
    }else if(stat == 0){
      //realisasi
      $(
        function() {
          $('#pilihUserCKPR').modal();
        }
      );
    }
  }
  createCKPTarget(): void{
    this.spinner.show();
    this.myData.getCKPTGet(this.bulan_aktive, this.tahun_aktive).subscribe({
      next: data => this.createCKPTargetProcess(1, data),
      error: error => this.createCKPTargetProcess(0, error)
    });
  }
  createCKPTargetProcess(hasil: number, data: any): void{
    if(hasil == 1){
      this.capainIndividuCalon = [];
      this.thisCKP = new CKP();
      this.thisCKP.bulan = this.bulan_aktive.toString();
      this.thisCKP.tahun = this.tahun_aktive.toString();
      this.thisCKP.ckp_item = [];
      data['individu'].forEach(element => {
        let itemCapaianbulan = new Capaian_Individu();
        itemCapaianbulan.setData(element);
        let itemCkp = new CKP_Item();
        itemCkp.capaian_individu_id = itemCapaianbulan.id;
        itemCkp.capaian_individu = itemCapaianbulan;
        itemCkp.nama = itemCapaianbulan.kegiatan_tahapan.nama
        itemCkp.satuan = itemCapaianbulan.kegiatan_tahapan.satuan;
        itemCkp.target = itemCapaianbulan.getTergetBulan(this.bulan_aktive);
        itemCkp.realisasi = itemCapaianbulan.getRealisasiBulan(this.bulan_aktive);
        itemCkp.is_delete = 0;
        this.thisCKP.ckp_item.push(itemCkp);
      });
      this.thisCKP_bulan_lalu = new CKP();
      if (data['ckp_bulan_lalu'] != null){
        this.thisCKP_bulan_lalu.setData(data['ckp_bulan_lalu']);
      }else{
        this.thisCKP_bulan_lalu.ckp_item_not_full = [];
      }
      this.newCKPTargetItem = [];
      this.statusBulanIni = 1;
      this.reRenderTable();
    }else if(hasil == 0){
      this.spinner.hide();
      console.error('Error get Kegiatan', data);
    }
  }
  deleteCKPTarget(type: number, id: string, index: number): void{
    // console.log('delete : '+type+'|'+id+ '|'+index );
    if (type == 0){
      //capain bulan lalu
      this.thisCKP_bulan_lalu.ckp_item_not_full = this.thisCKP_bulan_lalu.ckp_item_not_full.filter(item => item.id != id);
    }else if (type == 1){
      // capaian baru
      // console.log(index);
      let ckp_item_hasil = [];
      this.newCKPTargetItem.forEach((element, index2) => {
        if(index != index2){
          ckp_item_hasil.push(element);
        }
      });
      this.newCKPTargetItem = ckp_item_hasil;
    }
    this.reRenderTable();
  }
  tambahCKPTarget(): void{
    let itemBaru = new CKP_Item();
    itemBaru.capaian_individu_id = null;
    itemBaru.nama = '';
    itemBaru.satuan = '';
    itemBaru.target = 0;
    itemBaru.realisasi = 0;
    this.newCKPTargetItem.push(itemBaru);
    this.reRenderTable();
  }
  submit(): void{
    console.log(this.typeSubmit);
    if(this.typeSubmit==1){
      let isError = false;
      let errorMassage = '';
      this.thisCKP_bulan_lalu.ckp_item_not_full.forEach(element => {
        if(element){
          if(element.target<=0){
            isError = true;
            errorMassage  = 'Ada target 0 atau kurang';
          }
          console.log(element);
        }
      });
      this.newCKPTargetItem.forEach(element=>{
        if(element.nama == '' || element.satuan == '' || element.target == null || element.target <= 0){
          isError = true;
          errorMassage  = 'Ada isian kosong atau salah';
          console.log(element);
        }
      });
      if(isError){
        Swal.fire(
          'Error!',
          'Gagal kirim CKP-T. ' + errorMassage + '.',
          'error'
        );
        return;
      }
      this.submitCKPTarget();
      document.getElementById('closePilihUserCKPT').click();
    }else if(this.typeSubmit==2){
      this.submitCKPRealisasi();
      document.getElementById('closePilihUserCKPR').click();
    }
  }
  submitCKPTarget(): void{
    let itemsKirim: CKP_Item[] = [];
    this.thisCKP.ckp_item.forEach(element => {
      itemsKirim.push(element);
    });
    this.thisCKP_bulan_lalu.ckp_item_not_full.forEach(element => {
      itemsKirim.push(element);
    });
    this.newCKPTargetItem.forEach(element => {
      itemsKirim.push(element);
    });
    this.spinner.show();
    this.myData.getCKPTSubmit(this.bulan_aktive, this.tahun_aktive, this.nip_lama, itemsKirim).subscribe({
      next: data => this.submitCKPTargetProses(1, data),
      error: error => this.submitCKPTargetProses(0, null)
    });
  }
  submitCKPTargetProses(hasil: number, uuid: string): void{
    if(hasil == 1){
      this.thisCKP_bulan_lalu.ckp_item_not_full.forEach(element => {
        this.thisCKP.ckp_item.push(element);
      });
      this.thisCKP_bulan_lalu = new CKP();
      this.newCKPTargetItem.forEach(element => {
        this.thisCKP.ckp_item.push(element);
      });
      this.newCKPTargetItem = [];
      this.statusBulanIni = 2;
      this.thisCKP.id = uuid;
      this.thisCKP.nip_lama = this.nip_lama;
      this.nip_lama = null;
      this.reRenderTable();
      Swal.fire(
        'Berhasil!',
        'CKP berhasil dikirim.',
        'success'
      );
    }else if(hasil == 0){
      this.reRenderTable();
      Swal.fire(
        'Gagal!',
        'CKP gagal dikirim.',
        'error'
      );
    }
  }

  ubah(itemUbah: CKP_Item): void{
    itemUbah.isEdit = '1';
  }
  simpanUbah(itemUbah: CKP_Item): void{
    this.spinner.show();
    if (itemUbah.isEdit == '1'){
      itemUbah.isEdit = '0';
      this.myData.getCKPRUpdate(this.bulan_aktive, this.tahun_aktive, itemUbah.id, itemUbah.realisasi).subscribe({
        next: data => this.simpanUbahProcess(1, itemUbah),
        error: error => this.simpanUbahProcess(0, itemUbah)
      });
    }else if (itemUbah.isEdit == '2'){
      this.myData.getCKPRAdd(this.bulan_aktive, this.tahun_aktive, itemUbah).subscribe({
        next: data => this.simpanAddProcess(1, itemUbah),
        error: error => this.simpanAddProcess(0, null)
      });
    }
  }
  simpanUbahProcess(hasil: number, itemUbah: CKP_Item): void{
    if(hasil == 1){
      Swal.fire(
        'Berhasil!',
        'Berhasil ubah nilai realisasi.',
        'success'
      );
      this.thisCKPOri.ckp_item.forEach(element => {
        if(element.id == itemUbah.id){
          element.realisasi = itemUbah.realisasi;
        }
      });
      this.spinner.hide();
    }else{
      Swal.fire(
        'Gagal!',
        'Gagal ubah nilai realisasi.',
        'error'
      );
      this.thisCKPOri.ckp_item.forEach(element => {
        if(element.id == itemUbah.id){
          itemUbah.realisasi = element.realisasi;
        }
      });
      this.spinner.hide();
    }
    this.reRenderTable();
  }
  simpanAddProcess(hasil: number, itemAdd: CKP_Item): void{
    if(hasil == 1){
      itemAdd.isEdit = '0';
      Swal.fire(
        'Berhasil!',
        'Berhasil menambah item realisasi.',
        'success'
      );
      this.spinner.hide();
    }else{
      Swal.fire(
        'Gagal!',
        'Gagal menambah item realisasi.',
        'error'
      );
      this.spinner.hide();
    }
  }
  tambahCKPRealisasi(): void{
    let itemBaru = new CKP_Item();
    itemBaru.capaian_individu_id = null;
    itemBaru.nama = '';
    itemBaru.satuan = '';
    itemBaru.target = 0;
    itemBaru.realisasi = 0;
    itemBaru.isEdit = '2';
    this.thisCKP.ckp_item.push(itemBaru);
    this.reRenderTable();
  }
  editCKPRealisasi(): void{

  }
  deleteCKPRealisasi(): void{

  }
  submitCKPRealisasi(): void{
    this.myData.getCKPRSubmit(this.bulan_aktive, this.tahun_aktive, this.nip_lama).subscribe({
      next: data => this.submitCKPRealisasiProcess(1),
      error: error => this.submitCKPRealisasiProcess(0)
    });
  }
  submitCKPRealisasiProcess(hasil:number){
    if(hasil == 1){
      Swal.fire(
        'Berhasil!',
        'Berhasil mengirim CKP-Realisasi.',
        'success'
      );
      this.thisCKP.status = '1';
      this.statusBulanIni = 3;
      this.spinner.hide();
    }else{
      Swal.fire(
        'Gagal!',
        'Gagal mengirim CKP-Realisasi.',
        'error'
      );
      this.spinner.hide();
    }
    this.nip_lama = null;
  }

  loadDownload(type: number): void {
    this.nip_lama = null;
    this.typeSubmit = type;
    this.myData.getUser().subscribe({
      next: data => this.processUsersorMitra(type, data),
      error: error => console.error('Error get Kegiatan', error)
    });
  }
  downloadCKPTarget(): void{
    console.log("download");
    this.myData.downloadCKPTarget(this.bulan_aktive, this.tahun_aktive).subscribe({
      next: data => this.downloadFile(0, data),
      error: error => console.log("download error",error)
    });
  }

  downloadCKPRealisasi(): void{
    this.myData.downloadCKPRealisasi(this.bulan_aktive, this.tahun_aktive).subscribe({
      next: data => this.downloadFile(1, data),
      error: error => console.log("download error",error)
    });
  }
  downloadFile(type: number, data: Blob) {
    const blob = new Blob([data], { type: 'pdf' });
    let url= window.URL.createObjectURL(blob);
    var anchor = document.createElement("a");
    anchor.download = "CKP-T "+this.bulan_list[this.bulan_aktive]+".pdf";
    anchor.href = url;
    anchor.click();
  }
}
