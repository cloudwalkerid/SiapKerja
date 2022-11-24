import { Component, OnInit } from '@angular/core';
import { MyDataService } from '../my-data.service';
import { Kegiatan } from '../Object/Object';
import Swal from 'sweetalert2';
import { NgxSpinnerService } from 'ngx-spinner';

declare var $: any;
declare var Cleave: any;

@Component({
  selector: 'app-tambah-kegiatan',
  templateUrl: './tambah-kegiatan.component.html',
  styleUrls: ['./tambah-kegiatan.component.css']
})



export class TambahKegiatanComponent implements OnInit {

  nama: string;
  seksi: string;
  anggaran: string;

  isProcess: boolean = false;


  constructor(public myData: MyDataService, private spinner: NgxSpinnerService) {
      this.seksi = myData.myUser.seksi_id;
    }

  ngOnInit(): void {
    $(
      function() {
        var cleaveC = new Cleave('.currency', {
          numeral: true,
          numeralThousandsGroupStyle: 'thousand'
      });
      }
    );
  }

  onSubmit(): void{
    this.spinner.show();
    // setTimeout('', 3000);
    if (this.nama != null && this.anggaran != null){
      let newKegiatan : Kegiatan = new Kegiatan();
      newKegiatan.nama = this.nama;
      newKegiatan.seksi_id = this.seksi;
      newKegiatan.anggaran = parseInt(this.anggaran.replace(/\./g,'').replace(/,/g,''));

      this.myData.createKegiatan(newKegiatan).subscribe({
        next: data => this.hasil(newKegiatan, 1, data),
        error: error => this.hasil(newKegiatan, 0, null)
      });
    }
  }

  hasil(kegiatanBaru: Kegiatan, hasil: number, idBaru: string): void{
    this.spinner.hide();
    // console.log(idBaru);
    if (hasil === 1){
      kegiatanBaru.id = idBaru;
      this.myData.myKegiatan.push(kegiatanBaru);
      Swal.fire(
        'Berhasil!',
        'Kegiatan baru berhasil dibuat.',
        'success'
      );
    }else if (hasil === 0){
      Swal.fire(
        'Gagal!',
        'Kegiatan baru gagal dibuat.',
        'error'
      );
    }
  }

}
