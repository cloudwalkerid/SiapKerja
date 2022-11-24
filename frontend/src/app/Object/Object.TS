export class User {

  id: string;
  username: string;
  nip_baru: string;
  nip_lama: string;
  nama: string;
  jabatan: string;
  golongan_terakhir: string;
  status_kendaraan: string;
  seksi_id: string;
  is_kasi_plt: string;

  seksi: Seksi;

  seksi_nama: string = '';

  setData(data: any) {
    this.id = data['id'];
    this.username = data['username'];
    this.nip_baru = data['nip_baru'];
    this.nip_lama = data['nip_lama'];
    this.nama = data['nama'];
    this.jabatan = data['jabatan'];
    this.golongan_terakhir = data['golongan_terakhir'];
    this.status_kendaraan = data['status_kendaraan'];
    this.seksi_id = data['seksi_id'];
    this.is_kasi_plt = data['is_kasi_plt'];

    if ('seksi' in data) {
      if (data['seksi'] != null) {
        this.seksi = new Seksi();
        this.seksi.setData(data['seksi']);
        this.seksi_nama = this.seksi.nama;
      }
    }
  }
}

export class Seksi {

  id: string;
  nama: string;

  setData(data: any) {
    this.id = data['id'];
    this.nama = data['nama'];
  }
}

export class Mitra {
  id: string;
  nama: string;
  setData(data: any) {
    this.id = data['id'];
    this.nama = data['nama'];
  }
}

export class Kegiatan {
  id: string;
  seksi_id: string;
  nama: string;
  anggaran: number;
  anggaran_text: string;
  tahun: string;

  capaian_01: number;
  capaian_02: number;
  capaian_03: number;
  capaian_04: number;
  capaian_05: number;
  capaian_06: number;
  capaian_07: number;
  capaian_08: number;
  capaian_09: number;
  capaian_10: number;
  capaian_11: number;
  capaian_12: number;
  capaian_total: number = 0;

  kegiatan_tahapan: Tahapan_Kegiatan[];
  kegiatan_tahapan_mulai: Tahapan_Kegiatan[];
  p_j: Kegiatan_PJ[];
  capaian_tahapan: Capaian_Tahapan[];
  capaian_individu: Capaian_Individu[];
  seksi: Seksi;

  setData(element: any) {
    this.id = element['id'];
    this.seksi_id = element['seksi_id'];
    this.nama = element['nama'];
    this.anggaran = element['anggaran'];
    this.anggaran_text = element['anggaran'].toString();
    this.tahun = element['tahun'];
    this.capaian_01 = element['capaian_01'];
    this.capaian_02 = element['capaian_02'];
    this.capaian_03 = element['capaian_03'];
    this.capaian_04 = element['capaian_04'];
    this.capaian_05 = element['capaian_05'];
    this.capaian_06 = element['capaian_06'];
    this.capaian_07 = element['capaian_07'];
    this.capaian_08 = element['capaian_08'];
    this.capaian_09 = element['capaian_09'];
    this.capaian_10 = element['capaian_10'];
    this.capaian_11 = element['capaian_11'];
    this.capaian_12 = element['capaian_12'];
    this.capaian_total = element['capaian_total'];

    if ('kegiatan_tahapan_mulai' in element) {
      if (element['kegiatan_tahapan_mulai'] != null) {
        this.kegiatan_tahapan_mulai = [];
        element['kegiatan_tahapan_mulai'].forEach(element2 => {
          let itemKegiatanTah = new Tahapan_Kegiatan();
          itemKegiatanTah.setData(element2);
          this.kegiatan_tahapan_mulai.push(itemKegiatanTah);
        });
      }
    }
    if ('kegiatan_tahapan' in element) {
      if (element['kegiatan_tahapan'] != null) {
        this.kegiatan_tahapan = [];
        element['kegiatan_tahapan'].forEach(element2 => {
          let itemKegiatanTah = new Tahapan_Kegiatan();
          itemKegiatanTah.setData(element2);
          this.kegiatan_tahapan.push(itemKegiatanTah);
        });
      }
    }
    if ('p_j' in element) {
      if (element['p_j'] != null) {
        this.p_j = [];
        element['p_j'].forEach(element2 => {
          let itemPJ = new Kegiatan_PJ();
          itemPJ.setData(element2);
          this.p_j.push(itemPJ);
        });
        this.p_j = this.p_j.reverse();
      }
    }
    if ('capaian_tahapan' in element) {
      if (element['capaian_tahapan'] != null) {
        this.capaian_tahapan = [];
        element['capaian_tahapan'].forEach(element2 => {
          let itemCapaianTah = new Capaian_Tahapan();
          itemCapaianTah.setData(element2);
          this.capaian_tahapan.push(itemCapaianTah);
        });
      }
    }
    if ('capaian_individu' in element) {
      if (element['capaian_individu'] != null) {
        this.capaian_individu = [];
        element['capaian_individu'].forEach(element2 => {
          let itemCapaianInd = new Capaian_Individu();
          itemCapaianInd.setData(element2);
          this.capaian_individu.push(itemCapaianInd);
        });
      }
    }
  }
  checkIfuserPj(user: User): boolean{
    if(this.p_j == null){
      return false;
    }else{
      let isPJ = false;
      this.p_j.forEach(element => {
        if(element.nip_lama == user.nip_lama){
          isPJ = true;
        }
      });
      return isPJ;
    }
  }
}

export class Kegiatan_PJ {

  id: string;
  kegiatan_id: string;
  nip_lama: string;

  kegiatan: Kegiatan;
  user: User;

  setData(element: any) {
    this.id = element['id'];
    this.kegiatan_id = element['kegiatan_id'];
    this.nip_lama = element['nip_lama'];

    if ('kegiatan' in element) {
      if (element['kegiatan'] != null) {
        this.kegiatan = new Kegiatan();
        this.kegiatan.setData(element['kegiatan']);
      }
    }
    if ('user' in element) {
      if (element['user'] != null) {
        this.user = new User();
        this.user.setData(element['user']);
      }
    }
  }
}

export class Tahapan_Kegiatan {
  id: string;
  seksi_id: string;
  kegiatan_id: string;
  nama: string;
  satuan: string;
  target_all: number;
  ref_kode: string;
  bobot_kegiatan_tahapan: number;
  bulan_awal: number;
  bulan_akhir: number;
  awal: string;
  akhir: string;
  is_mulai: string;
  yang_isi: string;
  status_spd: string;
  tahun: string;

  capaian_01: number = 0;
  capaian_02: number = 0;
  capaian_03: number = 0;
  capaian_04: number = 0;
  capaian_05: number = 0;
  capaian_06: number = 0;
  capaian_07: number = 0;
  capaian_08: number = 0;
  capaian_09: number = 0;
  capaian_10: number = 0;
  capaian_11: number = 0;
  capaian_12: number = 0;
  capaian_total: number = 0;

  kegiatan: Kegiatan;
  alokasi_dl: Tahapan_Alokasi_DL[];
  capaian_tahapan: Capaian_Tahapan;
  capaian_individu: Capaian_Individu[];
  refKegiatan: Ref_Tahapan;
  seksi: Seksi;
  capaianIndividuPairDL: Capaian_Individu_Pair_DL[] = [];
  deletedCapaianIndividuPairDL: Capaian_Individu_Pair_DL[] = [];

  setData(data: any) {
    this.id = data['id'];
    this.seksi_id = data['seksi_id'];
    this.kegiatan_id = data['kegiatan_id'];
    this.nama = data['nama'];
    this.satuan = data['satuan'];
    this.target_all = data['target_all'];
    this.ref_kode = data['ref_kode'];
    this.bobot_kegiatan_tahapan = data['bobot_kegiatan_tahapan'];
    this.bulan_awal = data['bulan_awal'];
    this.bulan_akhir = data['bulan_akhir'];
    this.awal = data['awal'];
    this.akhir = data['akhir'];
    this.is_mulai = data['is_mulai'];
    this.yang_isi = data['yang_isi'];
    this.status_spd = data['status_spd'];
    this.tahun = data['tahun'];

    this.capaian_01 = data['capaian_01'];
    this.capaian_02 = data['capaian_02'];
    this.capaian_03 = data['capaian_03'];
    this.capaian_04 = data['capaian_04'];
    this.capaian_05 = data['capaian_05'];
    this.capaian_06 = data['capaian_06'];
    this.capaian_07 = data['capaian_07'];
    this.capaian_08 = data['capaian_08'];
    this.capaian_09 = data['capaian_09'];
    this.capaian_10 = data['capaian_10'];
    this.capaian_11 = data['capaian_11'];
    this.capaian_12 = data['capaian_12'];
    this.capaian_total = data['capaian_total'];

    if ('kegiatan' in data) {
      if (data['kegiatan'] != null) {
        this.kegiatan = new Kegiatan();
        this.kegiatan.setData(data['kegiatan']);
      }
    }
    if ('capaian_tahapan' in data) {
      if (data['capaian_tahapan'] != null) {
        this.capaian_tahapan = new Capaian_Tahapan();
        this.capaian_tahapan.setData(data['capaian_tahapan']);
      }
    }
    if ('refKegiatan' in data) {
      if (data['refKegiatan'] != null) {
        this.refKegiatan = new Ref_Tahapan();
        this.refKegiatan.setData(data['refKegiatan']);
      }
    }
    if ('capaian_individu' in data) {
      if (data['capaian_individu'] != null) {
        this.capaian_individu = [];
        data['capaian_individu'].forEach(element => {
          let itemCapaianInd = new Capaian_Individu();
          itemCapaianInd.setData(element);
          this.capaian_individu.push(itemCapaianInd);
        });
      }
    }
    if ('alokasi_dl' in data) {
      if (data['alokasi_dl'] != null) {
        this.alokasi_dl = [];
        data['alokasi_dl'].forEach(element => {
          let itemAlokasiDL = new Tahapan_Alokasi_DL();
          itemAlokasiDL.setData(element);
          this.alokasi_dl.push(itemAlokasiDL);
        });
      }
    }
    if(this.alokasi_dl != null && this.capaian_individu !=null){
      if(this.capaian_individu.length>0){
        this.capaianIndividuPairDL = []
        this.capaian_individu.forEach(element => {
          let itemPair = new Capaian_Individu_Pair_DL();
          itemPair.id = element.id;
          itemPair.capaianIndividu = element;

          if(element.nip_lama != null){
            itemPair.nip_lama = element.nip_lama;
            itemPair.status_user = '0';
          }else{
            itemPair.nip_lama = '';
          }

          if(element.mitra_id != null){
            itemPair.mitra_id = element.mitra_id;
            itemPair.alokasi_dl = new Tahapan_Alokasi_DL();
            itemPair.status_user = '1';
          }else{
            itemPair.mitra_id = '';
          }
          
          this.alokasi_dl.forEach(element2 => {
            if(element2.id == element.id){
              itemPair.alokasi_dl = element2;
            }
          });
          this.capaianIndividuPairDL.push(itemPair);
        });
        // this.capaianIndividuPairDL = this.capaianIndividuPairDL.reverse();
      }
    }
  }
  hitungCapaianTahapan(): void{
    if( this.yang_isi == '0'){
      return;
    }
    if(this.capaianIndividuPairDL!=null){
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
      let target_total = 0;
      this.capaianIndividuPairDL.forEach(element => {
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
        element.hitungTargetAll();
      });
      target_total = target_total + target_01;
      target_total = target_total + target_02;
      target_total = target_total + target_03;
      target_total = target_total + target_04;
      target_total = target_total + target_05;
      target_total = target_total + target_06;
      target_total = target_total + target_07;
      target_total = target_total + target_08;
      target_total = target_total + target_09;
      target_total = target_total + target_10;
      target_total = target_total + target_11;
      target_total = target_total + target_12;

      this.capaian_tahapan.target_01 = target_01;
      this.capaian_tahapan.target_02 = target_02;
      this.capaian_tahapan.target_03 = target_03;
      this.capaian_tahapan.target_04 = target_04;
      this.capaian_tahapan.target_05 = target_05;
      this.capaian_tahapan.target_06 = target_06;
      this.capaian_tahapan.target_07 = target_07;
      this.capaian_tahapan.target_08 = target_08;
      this.capaian_tahapan.target_09 = target_09;
      this.capaian_tahapan.target_10 = target_10;
      this.capaian_tahapan.target_11 = target_11;
      this.capaian_tahapan.target_12 = target_12;
      this.capaian_tahapan.target_all = target_total;
    }
  }
  deleteUser(): void{
    this.capaianIndividuPairDL.forEach(element => {
      element.capaianIndividu.user = null;
      element.alokasi_dl.user == null;
    });
  }
  checkIfAktiveInBulan(bulanAktive: number): boolean {
    if(this.bulan_awal<=bulanAktive && bulanAktive<=this.bulan_akhir){
      return true;
    }else{
      return false;
    }
  }
  checkIfBelumPenuhInBulan(bulanAktive): boolean {
    if(bulanAktive==1){
      return false;
    }else if(bulanAktive==2){
      return (this.capaian_01 != 100);
    }else if(bulanAktive==3){
      return (this.capaian_02 != 100);
    }else if(bulanAktive==4){
      return (this.capaian_03 != 100);
    }else if(bulanAktive==5){
      return (this.capaian_04 != 100);
    }else if(bulanAktive==6){
      return (this.capaian_05 != 100);
    }else if(bulanAktive==7){
      return (this.capaian_06 != 100);
    }else if(bulanAktive==8){
      return (this.capaian_07 != 100);
    }else if(bulanAktive==9){
      return (this.capaian_08 != 100);
    }else if(bulanAktive==10){
      return (this.capaian_09 != 100);
    }else if(bulanAktive==11){
      return (this.capaian_10 != 100);
    }else if(bulanAktive==12){
      return (this.capaian_11 != 100);
    }
  }
}

export class Ref_Tahapan {
  id: number;
  ref_kode: string;
  nama: string;
  bobot: number;
  setData(data: any) {
    this.id = data['id'];
    this.ref_kode = data['ref_kode'];
    this.nama = data['nama'];
    this.bobot = data['bobot'];
  }
}

export class Tahapan_Alokasi_DL {

  id: string;
  nip_lama: string;
  seksi_id: string;
  status_spd: string;
  kegiatan_id: string;
  kegiatan_tahapan_id: string;
  jumlah_dl: number;
  real_jumlah_dl: number;
  awal: string;
  akhir: string;
  tahun: string;

  user: User;
  kegiatan: Kegiatan;
  kegiatan_tahapan: Tahapan_Kegiatan;
  DL: DL[];

  setData(data: any) {
    this.id = data['id'];
    this.nip_lama = data['nip_lama'];
    this.seksi_id = data['seksi_id'];
    this.status_spd = data['status_spd'];
    this.kegiatan_id = data['kegiatan_id'];
    this.kegiatan_tahapan_id = data['kegiatan_tahapan_id'];
    this.jumlah_dl = data['jumlah_dl'];
    this.real_jumlah_dl = data['real_jumlah_dl'];
    this.awal = data['awal'];
    this.akhir = data['akhir'];
    this.tahun = data['tahun'];

    if ('user' in data) {
      if (data['user'] != null) {
        this.user = new User();
        this.user.setData(data['user']);
      }
    }
    if ('kegiatan' in data) {
      if (data['kegiatan'] != null) {
        this.kegiatan = new Kegiatan();
        this.kegiatan.setData(data['kegiatan']);
      }
    }
    if ('kegiatan_tahapan' in data) {
      if (data['kegiatan_tahapan'] != null) {
        this.kegiatan_tahapan = new Tahapan_Kegiatan();
        this.kegiatan_tahapan.setData(data['kegiatanTahapan']);
      }
    }
    if ('DL' in data) {
      if (data['DL'] != null) {
        this.DL = []
        data['DL'].forEach(element => {
          ;
          let itemDL = new DL();
          itemDL.setData(element);
          this.DL.push(itemDL);
        });
      }
    }
  }
}

export class Capaian_Tahapan {
  id: string;
  seksi_id: string;
  kegiatan_id: string;
  kegiatan_tahapan_id: string;
  target_all: number;
  is_mulai: string;
  yang_isi: string;
  bulan_awal: number;
  bulan_akhir: number;
  tahun: string;

  target_01: number;
  target_02: number;
  target_03: number;
  target_04: number;
  target_05: number;
  target_06: number;
  target_07: number;
  target_08: number;
  target_09: number;
  target_10: number;
  target_11: number;
  target_12: number;
  realisasi_01: number;
  realisasi_02: number;
  realisasi_03: number;
  realisasi_04: number;
  realisasi_05: number;
  realisasi_06: number;
  realisasi_07: number;
  realisasi_08: number;
  realisasi_09: number;
  realisasi_10: number;
  realisasi_11: number;
  realisasi_12: number;

  capaian_komulatif_01: number;
  capaian_komulatif_02: number;
  capaian_komulatif_03: number;
  capaian_komulatif_04: number;
  capaian_komulatif_05: number;
  capaian_komulatif_06: number;
  capaian_komulatif_07: number;
  capaian_komulatif_08: number;
  capaian_komulatif_09: number;
  capaian_komulatif_10: number;
  capaian_komulatif_11: number;
  capaian_komulatif_12: number;

  kegiatan: Kegiatan;
  kegiatan_tahapan: Tahapan_Kegiatan;
  capaian_individu: Capaian_Individu[];

  status_ubah: string = '0';
  isEdit: number = 0 ;// 0 tidak; 1 ya

  setData(data: any) {
    this.id = data['id'];
    this.seksi_id = data['seksi_id'];
    this.kegiatan_id = data['kegiatan_id'];
    this.kegiatan_tahapan_id = data['kegiatan_tahapan_id'];
    this.target_all = data['target_all'];
    this.is_mulai = data['is_mulai'];
    this.yang_isi = data['yang_isi'];
    this.bulan_awal = data['bulan_awal'];
    this.bulan_akhir = data['bulan_akhir'];
    this.tahun = data['tahun'];

    this.target_01 = data['target_01'];
    this.target_02 = data['target_02'];
    this.target_03 = data['target_03'];
    this.target_04 = data['target_04'];
    this.target_05 = data['target_05'];
    this.target_06 = data['target_06'];
    this.target_07 = data['target_07'];
    this.target_08 = data['target_08'];
    this.target_09 = data['target_09'];
    this.target_10 = data['target_10'];
    this.target_11 = data['target_11'];
    this.target_12 = data['target_12'];

    this.realisasi_01 = data['realisasi_01'];
    this.realisasi_02 = data['realisasi_02'];
    this.realisasi_03 = data['realisasi_03'];
    this.realisasi_04 = data['realisasi_04'];
    this.realisasi_05 = data['realisasi_05'];
    this.realisasi_06 = data['realisasi_06'];
    this.realisasi_07 = data['realisasi_07'];
    this.realisasi_08 = data['realisasi_08'];
    this.realisasi_09 = data['realisasi_09'];
    this.realisasi_10 = data['realisasi_10'];
    this.realisasi_11 = data['realisasi_11'];
    this.realisasi_12 = data['realisasi_12'];

    this.capaian_komulatif_01 = data['capaian_komulatif_01'];
    this.capaian_komulatif_02 = data['capaian_komulatif_02'];
    this.capaian_komulatif_03 = data['capaian_komulatif_03'];
    this.capaian_komulatif_04 = data['capaian_komulatif_04'];
    this.capaian_komulatif_05 = data['capaian_komulatif_05'];
    this.capaian_komulatif_06 = data['capaian_komulatif_06'];
    this.capaian_komulatif_07 = data['capaian_komulatif_07'];
    this.capaian_komulatif_08 = data['capaian_komulatif_08'];
    this.capaian_komulatif_09 = data['capaian_komulatif_09'];
    this.capaian_komulatif_10 = data['capaian_komulatif_10'];
    this.capaian_komulatif_11 = data['capaian_komulatif_11'];
    this.capaian_komulatif_12 = data['capaian_komulatif_12'];

    if ('kegiatan' in data) {
      if (data['kegiatan'] != null) {
        this.kegiatan = new Kegiatan();
        this.kegiatan.setData(data['kegiatan']);
      }
    }
    if ('kegiatan_tahapan' in data) {
      if (data['kegiatan_tahapan'] != null) {
        this.kegiatan_tahapan = new Tahapan_Kegiatan();
        this.kegiatan_tahapan.setData(data['kegiatan_tahapan']);
      }
    }
    if ('capaian_individu' in data) {
      if (data['capaian_individu'] != null) {
        this.capaian_individu = [];
        data['capaian_individu'].forEach(element => {
          let itemIndividu = new Capaian_Individu();
          itemIndividu.setData(element);
          this.capaian_individu.push(itemIndividu);
        });
      }
    }
  }
  getTargetAll(): number {
    return this.target_01 + this.target_02 + this.target_03 + this.target_04
      + this.target_05 + this.target_06 + this.target_07 + this.target_08 + this.target_09
      + this.target_10 + this.target_11 + this.target_12;
  }
  getRealisasiAll(): number {
    return this.realisasi_01 + this.realisasi_02 + this.realisasi_03 + this.realisasi_04
      + this.realisasi_05 + this.realisasi_06 + this.realisasi_07 + this.realisasi_08 + this.realisasi_09
      + this.realisasi_10 + this.realisasi_11 + this.realisasi_12;
  }
  checkNoMinus(): boolean{
    if(this.target_01<0 || this.target_02<0 || this.target_03<0 || this.target_04<0 || this.target_05<0 || this.target_06<0
      || this.target_07<0 || this.target_08<0 || this.target_09<0 || this.target_10<0 || this.target_11<0 || this.target_12<0){
      return false;
    }
    if(this.realisasi_01<0 || this.realisasi_02<0 || this.realisasi_03<0 || this.realisasi_04<0 || this.realisasi_05<0 || this.realisasi_06<0
      || this.realisasi_07<0 || this.realisasi_08<0 || this.realisasi_09<0 || this.realisasi_10<0 || this.realisasi_11<0 || this.realisasi_12<0){
      return false;
    }
    return true;
  }
  getTergetBulan(bulan: number): number{
    switch(bulan){
      case 1: return this.target_01;
      case 2: return this.target_02;
      case 3: return this.target_03;
      case 4: return this.target_04;
      case 5: return this.target_05;
      case 6: return this.target_06;
      case 7: return this.target_07;
      case 8: return this.target_08;
      case 9: return this.target_09;
      case 10: return this.target_10;
      case 11: return this.target_11;
      case 12: return this.target_12;
    }
  }
  getRealisasiBulan(bulan: number): number{
    switch(bulan){
      case 1: return this.realisasi_01;
      case 2: return this.realisasi_02;
      case 3: return this.realisasi_03;
      case 4: return this.realisasi_04;
      case 5: return this.realisasi_05;
      case 6: return this.realisasi_06;
      case 7: return this.realisasi_07;
      case 8: return this.realisasi_08;
      case 9: return this.realisasi_09;
      case 10: return this.realisasi_10;
      case 11: return this.realisasi_11;
      case 12: return this.realisasi_12;
    }
  }
  checkIfAktiveInBulan(bulanAktive: number): boolean {
    if(this.bulan_awal<=bulanAktive && bulanAktive<=this.bulan_akhir){
      return true;
    }else{
      return false;
    }
  }
  checkIfBelumPenuhInBulan(bulanAktive): boolean {
    if(bulanAktive==1){
      return false;
    }else if(bulanAktive==2){
      return (this.capaian_komulatif_01 != 100);
    }else if(bulanAktive==3){
      return (this.capaian_komulatif_02 != 100);
    }else if(bulanAktive==4){
      return (this.capaian_komulatif_03 != 100);
    }else if(bulanAktive==5){
      return (this.capaian_komulatif_04 != 100);
    }else if(bulanAktive==6){
      return (this.capaian_komulatif_05 != 100);
    }else if(bulanAktive==7){
      return (this.capaian_komulatif_06 != 100);
    }else if(bulanAktive==8){
      return (this.capaian_komulatif_07 != 100);
    }else if(bulanAktive==9){
      return (this.capaian_komulatif_08 != 100);
    }else if(bulanAktive==10){
      return (this.capaian_komulatif_09 != 100);
    }else if(bulanAktive==11){
      return (this.capaian_komulatif_10 != 100);
    }else if(bulanAktive==12){
      return (this.capaian_komulatif_11 != 100);
    }
  }
}

export class Capaian_Individu {
  id: string;
  nip_lama: string;
  mitra_id: string;
  seksi_id: string;
  mitra_nama: string;
  tujuan: string;
  status_user: string;
  kegiatan_id: string;
  kegiatan_tahapan_id: string;
  target_all: number;
  is_mulai: string;
  yang_isi: string;
  bulan_awal: number;
  bulan_akhir: number;
  tahun: string;
  capaian_tahapan_id: string;

  target_01: number;
  target_02: number;
  target_03: number;
  target_04: number;
  target_05: number;
  target_06: number;
  target_07: number;
  target_08: number;
  target_09: number;
  target_10: number;
  target_11: number;
  target_12: number;
  realisasi_01: number;
  realisasi_02: number;
  realisasi_03: number;
  realisasi_04: number;
  realisasi_05: number;
  realisasi_06: number;
  realisasi_07: number;
  realisasi_08: number;
  realisasi_09: number;
  realisasi_10: number;
  realisasi_11: number;
  realisasi_12: number;

  capaian_komulatif_01: number;
  capaian_komulatif_02: number;
  capaian_komulatif_03: number;
  capaian_komulatif_04: number;
  capaian_komulatif_05: number;
  capaian_komulatif_06: number;
  capaian_komulatif_07: number;
  capaian_komulatif_08: number;
  capaian_komulatif_09: number;
  capaian_komulatif_10: number;
  capaian_komulatif_11: number;
  capaian_komulatif_12: number;
  capaian_komulatif_all:number;

  user: User;
  mitra: Mitra;
  kegiatan: Kegiatan;
  kegiatan_tahapan: Tahapan_Kegiatan;
  capaianTahapan: Capaian_Tahapan;

  status_ubah: string = '0';  //0: update 1: insert 2: delete 
  isEdit: number = 0 ;// 0 tidak; 1 ya

  setData(data: any) {
    this.id = data['id'];
    this.nip_lama = data['nip_lama'];
    this.mitra_id = data['mitra_id'];
    this.seksi_id = data['seksi_id'];
    this.tujuan = data['tujuan'];
    this.kegiatan_id = data['kegiatan_id'];
    this.kegiatan_tahapan_id = data['kegiatan_tahapan_id'];
    this.target_all = data['target_all'];
    this.is_mulai = data['is_mulai'];
    this.yang_isi = data['yang_isi'];
    this.status_user = data['status_user'];
    this.bulan_awal = data['bulan_awal'];
    this.bulan_akhir = data['bulan_akhir'];
    this.tahun = data['tahun'];
    this.capaian_tahapan_id = data['capaian_tahapan_id'];

    this.target_01 = data['target_01'];
    this.target_02 = data['target_02'];
    this.target_03 = data['target_03'];
    this.target_04 = data['target_04'];
    this.target_05 = data['target_05'];
    this.target_06 = data['target_06'];
    this.target_07 = data['target_07'];
    this.target_08 = data['target_08'];
    this.target_09 = data['target_09'];
    this.target_10 = data['target_10'];
    this.target_11 = data['target_11'];
    this.target_12 = data['target_12'];

    this.realisasi_01 = data['realisasi_01'];
    this.realisasi_02 = data['realisasi_02'];
    this.realisasi_03 = data['realisasi_03'];
    this.realisasi_04 = data['realisasi_04'];
    this.realisasi_05 = data['realisasi_05'];
    this.realisasi_06 = data['realisasi_06'];
    this.realisasi_07 = data['realisasi_07'];
    this.realisasi_08 = data['realisasi_08'];
    this.realisasi_09 = data['realisasi_09'];
    this.realisasi_10 = data['realisasi_10'];
    this.realisasi_11 = data['realisasi_11'];
    this.realisasi_12 = data['realisasi_12'];

    this.capaian_komulatif_01 = data['capaian_komulatif_01'];
    this.capaian_komulatif_02 = data['capaian_komulatif_02'];
    this.capaian_komulatif_03 = data['capaian_komulatif_03'];
    this.capaian_komulatif_04 = data['capaian_komulatif_04'];
    this.capaian_komulatif_05 = data['capaian_komulatif_05'];
    this.capaian_komulatif_06 = data['capaian_komulatif_06'];
    this.capaian_komulatif_07 = data['capaian_komulatif_07'];
    this.capaian_komulatif_08 = data['capaian_komulatif_08'];
    this.capaian_komulatif_09 = data['capaian_komulatif_09'];
    this.capaian_komulatif_10 = data['capaian_komulatif_10'];
    this.capaian_komulatif_11 = data['capaian_komulatif_11'];
    this.capaian_komulatif_12 = data['capaian_komulatif_12'];
    this.capaian_komulatif_all = data['capaian_komulatif_all'];

    if ('user' in data) {
      if (data['user'] != null) {
        this.user = new User();
        this.user.setData(data['user']);
      }
    }
    if ('mitra' in data) {
      if (data['mitra'] != null) {
        this.mitra = new Mitra();
        this.mitra.setData(data['mitra']);
      }
    }
    if ('kegiatan' in data) {
      if (data['kegiatan'] != null) {
        this.kegiatan = new Kegiatan();
        this.kegiatan.setData(data['kegiatan']);
      }
    }
    if ('kegiatan_tahapan' in data) {
      if (data['kegiatan_tahapan'] != null) {
        this.kegiatan_tahapan = new Tahapan_Kegiatan();
        this.kegiatan_tahapan.setData(data['kegiatan_tahapan']);
      }
    }
    if ('capaianTahapan' in data) {
      if (data['capaianTahapan'] != null) {
        this.capaianTahapan = new Capaian_Tahapan();
        this.capaianTahapan.setData(data['capaianTahapan']);
      }
    }
  }

  setTargetAll(): void {
    this.target_all = this.target_01 + this.target_02 + this.target_03 + this.target_04
      + this.target_05 + this.target_06 + this.target_07 + this.target_08 + this.target_09
      + this.target_10 + this.target_11 + this.target_12;
  }
  getTargetAll(): number {
    return this.target_01 + this.target_02 + this.target_03 + this.target_04
      + this.target_05 + this.target_06 + this.target_07 + this.target_08 + this.target_09
      + this.target_10 + this.target_11 + this.target_12;
  }
  checkNoMinus(): boolean{
    if(this.target_01<0 || this.target_02<0 || this.target_03<0 || this.target_04<0 || this.target_05<0 || this.target_06<0
      || this.target_07<0 || this.target_08<0 || this.target_09<0 || this.target_10<0 || this.target_11<0 || this.target_12<0){
      return false;
    }
    if(this.realisasi_01<0 || this.realisasi_02<0 || this.realisasi_03<0 || this.realisasi_04<0 || this.realisasi_05<0 || this.realisasi_06<0
      || this.realisasi_07<0 || this.realisasi_08<0 || this.realisasi_09<0 || this.realisasi_10<0 || this.realisasi_11<0 || this.realisasi_12<0){
      return false;
    }
    return true;
  }
  getRealisasiAll(): number {
    return this.realisasi_01 + this.realisasi_02 + this.realisasi_03 + this.realisasi_04
      + this.realisasi_05 + this.realisasi_06 + this.realisasi_07 + this.realisasi_08 + this.realisasi_09
      + this.realisasi_10 + this.realisasi_11 + this.realisasi_12;
  }
  getTergetBulan(bulan: number): number{
    switch(bulan){
      case 1: return this.target_01;
      case 2: return this.target_02;
      case 3: return this.target_03;
      case 4: return this.target_04;
      case 5: return this.target_05;
      case 6: return this.target_06;
      case 7: return this.target_07;
      case 8: return this.target_08;
      case 9: return this.target_09;
      case 10: return this.target_10;
      case 11: return this.target_11;
      case 12: return this.target_12;
    }
  }
  getRealisasiBulan(bulan: number): number{
    switch(bulan){
      case 1: return this.realisasi_01;
      case 2: return this.realisasi_02;
      case 3: return this.realisasi_03;
      case 4: return this.realisasi_04;
      case 5: return this.realisasi_05;
      case 6: return this.realisasi_06;
      case 7: return this.realisasi_07;
      case 8: return this.realisasi_08;
      case 9: return this.realisasi_09;
      case 10: return this.realisasi_10;
      case 11: return this.realisasi_11;
      case 12: return this.realisasi_12;
    }
  }
  checkIfAktiveInBulan(bulanAktive: number): boolean {
    if(this.bulan_awal<=bulanAktive && bulanAktive<=this.bulan_akhir){
      return true;
    }else{
      return false;
    }
  }
  checkIfBelumPenuhInBulan(bulanAktive): boolean {
    if(bulanAktive==1){
      return false;
    }else if(bulanAktive==2){
      return (this.capaian_komulatif_01 != 100);
    }else if(bulanAktive==3){
      return (this.capaian_komulatif_02 != 100);
    }else if(bulanAktive==4){
      return (this.capaian_komulatif_03 != 100);
    }else if(bulanAktive==5){
      return (this.capaian_komulatif_04 != 100);
    }else if(bulanAktive==6){
      return (this.capaian_komulatif_05 != 100);
    }else if(bulanAktive==7){
      return (this.capaian_komulatif_06 != 100);
    }else if(bulanAktive==8){
      return (this.capaian_komulatif_07 != 100);
    }else if(bulanAktive==9){
      return (this.capaian_komulatif_08 != 100);
    }else if(bulanAktive==10){
      return (this.capaian_komulatif_09 != 100);
    }else if(bulanAktive==11){
      return (this.capaian_komulatif_10 != 100);
    }else if(bulanAktive==12){
      return (this.capaian_komulatif_11 != 100);
    }
  }
}

export class CKP {

  id: string;
  nip_lama: string;
  bulan: string;
  tahun: string;
  status: string;

  ttd_t_nip_lama: string;
  ttd_r_nip_lama: string;

  user: User;
  ttd_t: User;
  ttd_r: User;
  ckp_item: CKP_Item[];
  ckp_item_not_full: CKP_Item[];

  setData(data: any) {
    this.id = data['id'];
    this.nip_lama = data['nip_lama'];
    this.bulan = data['bulan'];
    this.tahun = data['tahun'];
    this.status = data['status'];
    this.ttd_t_nip_lama = data['ttd_t_nip_lama'];
    this.ttd_r_nip_lama = data['ttd_r_nip_lama'];

    if ('user' in data) {
      if (data['user'] != null) {
        this.user = new User();
        this.user.setData(data['user']);
      }
    }
    if ('ttd_t' in data) {
      if (data['ttd_t'] != null) {
        this.ttd_t = new User();
        this.ttd_t.setData(data['ttd_t']);
      }
    }
    if ('ttd_r' in data) {
      if (data['ttd_r'] != null) {
        this.ttd_r = new User();
        this.ttd_r.setData(data['ttd_r']);
      }
    }
    if ('ckp_item' in data) {
      this.ckp_item = [];
      data['ckp_item'].forEach(element => {
        let itemCKP =  new CKP_Item();
        itemCKP.setData(element);
        this.ckp_item.push(itemCKP);
      });
    }
    if ('ckp_item_not_full' in data) {
      this.ckp_item_not_full = [];
      data['ckp_item_not_full'].forEach(element => {
        let itemCKP =  new CKP_Item();
        itemCKP.setData(element);
        itemCKP.target = itemCKP.target - itemCKP.realisasi;
        itemCKP.realisasi = 0;
        this.ckp_item_not_full.push(itemCKP);
      });
    }
  }
  checkNoMinus(): boolean{
    let noMinus = true;
    if(this.ckp_item!=null){
      this.ckp_item.forEach(element => {
        if(!element.checkNoMinus()){
          noMinus = false;
        }
      });
    }
    return noMinus;
  }
  checkNoMinusBulanLalu(): boolean{
    let noMinus = true;
    if(this.ckp_item_not_full!=null){
      this.ckp_item_not_full.forEach(element => {
        if(!element.checkNoMinus()){
          noMinus = false;
        }
      });
    }
    return noMinus;
  }
}

export class CKP_Item {

  id: string;
  ckp_id: string;
  capaian_individu_id: string;
  nama: string;
  satuan: string;
  target: number;
  realisasi: number;
  is_delete: number;

  ckp: CKP;
  capaian_individu: Capaian_Individu;
  isEdit: string = '0';

  setData(data: any) {
    this.id = data['id'];
    this.ckp_id = data['ckp_id'];
    this.capaian_individu_id = data['capaian_individu_id'];
    this.nama = data['nama'];
    this.satuan = data['satuan'];
    this.target = data['target'];
    this.realisasi = data['realisasi'];
    this.is_delete = data['is_delete'];

    if ('user' in data) {
      if (data['user'] != null) {
        this.ckp = new CKP();
        this.ckp.setData(data['user']);
      }
    }
    if ('capaian_individu' in data) {
      if (data['capaian_individu'] != null) {
        this.capaian_individu = new Capaian_Individu();
        this.capaian_individu.setData(data['capaian_individu']);
      }
    }
  }
  checkNoMinus(): boolean{
    if(this.target<0 || this. realisasi<0){
      return false;
    }
    return true;
  }
}

export class DL {

  id: string;
  nip_lama: string;
  seksi_id: string;
  status_spd: string;
  kegiatan_id: string;
  kegiatan_tahapan_id: string;
  kegiatan_tahapan_alokasi_dl_id: string;
  tanggal: string;
  bulan: string;
  tahun: string;

  kegiatan: Kegiatan;
  kegiatanTahapan: Tahapan_Kegiatan;
  tahapanAlokasi: Tahapan_Alokasi_DL;

  status_ubah: string = '0';  //0: update 1: insert 2: delete 

  setData(data: any) {
    this.id = data['id'];
    this.nip_lama = data['nip_lama'];
    this.seksi_id = data['seksi_id'];
    this.status_spd = data['status_spd'];
    this.kegiatan_id = data['kegiatan_id'];
    this.kegiatan_tahapan_id = data['kegiatan_tahapan_id'];
    this.kegiatan_tahapan_alokasi_dl_id = data['kegiatan_tahapan_alokasi_dl_id'];
    this.tanggal = data['tanggal'];
    this.bulan = data['bulan'];
    this.tahun = data['tahun'];

    if ('kegiatan' in data) {
      if (data['kegiatan'] != null) {
        this.kegiatan = new Kegiatan();
        this.kegiatan.setData(data['kegiatan']);
      }
    }
    if ('kegiatanTahapan' in data) {
      if (data['kegiatanTahapan'] != null) {
        this.kegiatanTahapan = new Tahapan_Kegiatan();
        this.kegiatanTahapan.setData(data['kegiatanTahapan']);
      }
    }
    if ('tahapanAlokasi' in data) {
      if (data['tahapanAlokasi'] != null) {
        this.tahapanAlokasi = new Tahapan_Alokasi_DL();
        this.tahapanAlokasi.setData(data['tahapanAlokasi']);
      }
    }

  }
}

export class Capaian_Individu_Pair_DL {
  id: string;
  capaianIndividu: Capaian_Individu;
  alokasi_dl: Tahapan_Alokasi_DL;
  status_ubah: string = '0';  //0: update 1: insert 2: delete 
  status_user: string = '0'
  nip_lama: string = '';
  mitra_id: string = '';
  mitra_nama: string = '';
  hitungTargetAll(): void{
    this.capaianIndividu.target_all = 0;
    this.capaianIndividu.target_all = this.capaianIndividu.target_01 + this.capaianIndividu.target_02 + this.capaianIndividu.target_03
        + this.capaianIndividu.target_04 + this.capaianIndividu.target_05 + this.capaianIndividu.target_06
        + this.capaianIndividu.target_07 + this.capaianIndividu.target_08 + this.capaianIndividu.target_09
        + this.capaianIndividu.target_10 + this.capaianIndividu.target_11 + this.capaianIndividu.target_12;
  }
}
