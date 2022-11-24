import {Seksi, Kegiatan} from './Object';

export class Beranda_Helper {

    satkerHelper: Capaian_Seksi_Helper;
    seksiHelper: Capaian_Seksi_Helper[] = [];
   

    setData(all_seksi: Seksi[],  kegiatans: Kegiatan[]): void{
        this.satkerHelper = new Capaian_Seksi_Helper();
        all_seksi.forEach(element => {
            let item = new Capaian_Seksi_Helper();
            item.seksi = element;
            this.seksiHelper.push(item);
        });
        kegiatans.forEach(element => {
           this.satkerHelper.setAngaran(element);
           this.seksiHelper.forEach(element2 => {
               if(element.seksi_id == element2.seksi.id){
                   element2.setAngaran(element)
               }
           });
        });

        kegiatans.forEach(element => {
           this.satkerHelper.setCapaian(element);
            this.seksiHelper.forEach(element2 => {
                if(element.seksi_id == element2.seksi.id){
                    element2.setCapaian(element);
                }
            });
        });
        this.satkerHelper.setProcessOver();
        this.seksiHelper.forEach(element => {
            element.setProcessOver();
        });
    }
    getCapainBulan(bulan: number): number{
        switch (bulan){
            case 0 : return this.satkerHelper.capaian_01;
            case 1 : return this.satkerHelper.capaian_02;
            case 2 : return this.satkerHelper.capaian_03;
            case 3 : return this.satkerHelper.capaian_04;
            case 4 : return this.satkerHelper.capaian_05;
            case 5 : return this.satkerHelper.capaian_06;
            case 6 : return this.satkerHelper.capaian_07;
            case 7 : return this.satkerHelper.capaian_08;
            case 8 : return this.satkerHelper.capaian_09;
            case 9 : return this.satkerHelper.capaian_10;
            case 10 : return this.satkerHelper.capaian_11;
            case 11 : return this.satkerHelper.capaian_12;
        }
    }

}

export class Capaian_Seksi_Helper {
    seksi: Seksi;
    anggaran_01: number = 0;
    anggaran_02: number = 0;
    anggaran_03: number = 0;
    anggaran_04: number = 0;
    anggaran_05: number = 0;
    anggaran_06: number = 0;
    anggaran_07: number = 0;
    anggaran_08: number = 0;
    anggaran_09: number = 0;
    anggaran_10: number = 0;
    anggaran_11: number = 0;
    anggaran_12: number = 0;
    anggaran_all: number = 0;

    capaian_01: number = null;
    capaian_02: number = null;
    capaian_03: number = null;
    capaian_04: number = null;
    capaian_05: number = null;
    capaian_06: number = null;
    capaian_07: number = null;
    capaian_08: number = null;
    capaian_09: number = null;
    capaian_10: number = null;
    capaian_11: number = null;
    capaian_12: number = null;
    capaian_total: number = null;

    color_succes: string = "rgb(71, 195, 99, .7)";
    color_warning: string = "rgb(255, 164, 38, .7)";
    color_error: string = "rgb(252, 84, 75, .7)"
    
    color_01: string = '';
    color_02: string = '';
    color_03: string = '';
    color_04: string = '';
    color_05: string = '';
    color_06: string = '';
    color_07: string = '';
    color_08: string = '';
    color_09: string = '';
    color_10: string = '';
    color_11: string = '';
    color_12: string = '';
    color_total: string = '';

    getCapainBulan(bulan: number): number{
        switch (bulan){
            case 0 : return this.capaian_01;
            case 1 : return this.capaian_02;
            case 2 : return this.capaian_03;
            case 3 : return this.capaian_04;
            case 4 : return this.capaian_05;
            case 5 : return this.capaian_06;
            case 6 : return this.capaian_07;
            case 7 : return this.capaian_08;
            case 8 : return this.capaian_09;
            case 9 : return this.capaian_10;
            case 10 : return this.capaian_11;
            case 11 : return this.capaian_12;
        }
    }

    getColorBulanA(bulan: number): string{
        switch (bulan){
            case 0 : return this.color_01;
            case 1 : return this.color_02;
            case 2 : return this.color_03;
            case 3 : return this.color_04;
            case 4 : return this.color_05;
            case 5 : return this.color_06;
            case 6 : return this.color_07;
            case 7 : return this.color_08;
            case 8 : return this.color_09;
            case 9 : return this.color_10;
            case 10 : return this.color_11;
            case 11 : return this.color_12;
        }
    }
  

    setAngaran(kegiatan: Kegiatan):void {
        if(kegiatan.capaian_01 != null){
            this.anggaran_01 = this.anggaran_01 + kegiatan.anggaran;
        }
        if(kegiatan.capaian_02 != null){
            this.anggaran_02 = this.anggaran_02 + kegiatan.anggaran;
        }
        if(kegiatan.capaian_03 != null){
            this.anggaran_03 = this.anggaran_03 + kegiatan.anggaran;
        }
        if(kegiatan.capaian_04 != null){
            this.anggaran_04 = this.anggaran_04 + kegiatan.anggaran;
        }
        if(kegiatan.capaian_05 != null){
            this.anggaran_05 = this.anggaran_05 + kegiatan.anggaran;
        }
        if(kegiatan.capaian_06 != null){
            this.anggaran_06 = this.anggaran_06 + kegiatan.anggaran;
        }
        if(kegiatan.capaian_07 != null){
            this.anggaran_07 = this.anggaran_07 + kegiatan.anggaran;
        }
        if(kegiatan.capaian_08 != null){
            this.anggaran_08 = this.anggaran_08 + kegiatan.anggaran;
        }
        if(kegiatan.capaian_09 != null){
            this.anggaran_09 = this.anggaran_09 + kegiatan.anggaran;
        }
        if(kegiatan.capaian_10 != null){
            this.anggaran_10 = this.anggaran_10 + kegiatan.anggaran;
        }
        if(kegiatan.capaian_11 != null){
            this.anggaran_11 = this.anggaran_11 + kegiatan.anggaran;
        }
        if(kegiatan.capaian_12 != null){
            this.anggaran_12 = this.anggaran_12 + kegiatan.anggaran;
        }
        this.anggaran_all = this.anggaran_all + kegiatan.anggaran;
    }

    setCapaian(kegiatan: Kegiatan):void {
        if(kegiatan.capaian_01 != null){
            this.capaian_01 = this.capaian_01 + (kegiatan.anggaran/this.anggaran_01)*kegiatan.capaian_01;
        }
        if(kegiatan.capaian_02 != null){
            this.capaian_02 = this.capaian_02 + (kegiatan.anggaran/this.anggaran_02)*kegiatan.capaian_02;
        }
        if(kegiatan.capaian_03 != null){
            this.capaian_03 = this.capaian_03 + (kegiatan.anggaran/this.anggaran_03)*kegiatan.capaian_03;
        }
        if(kegiatan.capaian_04 != null){
            this.capaian_04 = this.capaian_04 + (kegiatan.anggaran/this.anggaran_04)*kegiatan.capaian_04;
        }
        if(kegiatan.capaian_05 != null){
            this.capaian_05 = this.capaian_05 + (kegiatan.anggaran/this.anggaran_05)*kegiatan.capaian_05;
        }
        if(kegiatan.capaian_06 != null){
            this.capaian_06 = this.capaian_06 + (kegiatan.anggaran/this.anggaran_06)*kegiatan.capaian_06;
        }
        if(kegiatan.capaian_07 != null){
            this.capaian_07 = this.capaian_07 + (kegiatan.anggaran/this.anggaran_07)*kegiatan.capaian_07;
        }
        if(kegiatan.capaian_08 != null){
            this.capaian_08 = this.capaian_08 + (kegiatan.anggaran/this.anggaran_08)*kegiatan.capaian_08;
        }
        if(kegiatan.capaian_09 != null){
            this.capaian_09 = this.capaian_09 + (kegiatan.anggaran/this.anggaran_09)*kegiatan.capaian_09;
        }
        if(kegiatan.capaian_10 != null){
            this.capaian_10 = this.capaian_10 + (kegiatan.anggaran/this.anggaran_10)*kegiatan.capaian_10;
        }
        if(kegiatan.capaian_11 != null){
            this.capaian_11 = this.capaian_11 + (kegiatan.anggaran/this.anggaran_11)*kegiatan.capaian_11;
        }
        if(kegiatan.capaian_12 != null){
            this.capaian_12 = this.capaian_12 + (kegiatan.anggaran/this.anggaran_12)*kegiatan.capaian_12;
        }
        this.capaian_total = this.capaian_total + (kegiatan.anggaran/this.anggaran_all)*kegiatan.capaian_total;
    }

    setProcessOver(): void{
        let bulan_sekarang = (new Date()).getMonth()+1;
        if(this.capaian_01 == null && bulan_sekarang>1){
            this.capaian_01 = 100;
        }else if(this.capaian_01 == null){
            this.capaian_01 = 0;
        }
        if(this.capaian_01>120){
            this.capaian_01 = 120;
        }
        if(this.capaian_01 >= 100){
            this.color_01 = this.color_succes;
        }else if(this.capaian_01<100 && this.capaian_01>=50){
            this.color_01 = this.color_warning;
        }else if(this.capaian_01<50){
            this.color_01 = this.color_error;
        }
        // bulan
        if(this.capaian_02 == null && bulan_sekarang>2){
            this.capaian_02 = 100;
        }else if(this.capaian_02 == null){
            this.capaian_02 = 0;
        }
        if(this.capaian_02>120){
            this.capaian_02 = 120;
        }
        if(this.capaian_02 >= 100){
            this.color_02 = this.color_succes;
        }else if(this.capaian_02<100 && this.capaian_02>=50){
            this.color_02 = this.color_warning;
        }else if(this.capaian_02<50){
            this.color_02 = this.color_error;
        }
         // bulan
        if(this.capaian_03 == null && bulan_sekarang>3){
            this.capaian_03 = 100;
        }else if(this.capaian_03 == null){
            this.capaian_03 = 0;
        }
        if(this.capaian_03>120){
            this.capaian_03 = 120;
        }
        if(this.capaian_03 >= 100){
            this.color_03 = this.color_succes;
        }else if(this.capaian_03<100 && this.capaian_03>=50){
            this.color_03 = this.color_warning;
        }else if(this.capaian_03<50){
            this.color_03 = this.color_error;
        }
         // bulan
        if(this.capaian_04 == null && bulan_sekarang>4){
            this.capaian_04 = 100;
        }else if(this.capaian_04 == null){
            this.capaian_04 = 0;
        }
        if(this.capaian_04>120){
            this.capaian_04 = 120;
        }
        if(this.capaian_04 >= 100){
            this.color_04 = this.color_succes;
        }else if(this.capaian_04<100 && this.capaian_04>=50){
            this.color_04 = this.color_warning;
        }else if(this.capaian_04<50){
            this.color_04 = this.color_error;
        }
         // bulan
        if(this.capaian_05 == null && bulan_sekarang>5){
            this.capaian_05 = 100;
        }else if(this.capaian_05 == null){
            this.capaian_05 = 0;
        }
        if(this.capaian_05>120){
            this.capaian_05 = 120;
        }
        if(this.capaian_05 >= 100){
            this.color_05 = this.color_succes;
        }else if(this.capaian_05<100 && this.capaian_05>=50){
            this.color_05 = this.color_warning;
        }else if(this.capaian_05<50){
            this.color_05 = this.color_error;
        }
        // bulan
        if(this.capaian_06 == null && bulan_sekarang>6){
            this.capaian_06 = 100;
        }else if(this.capaian_06 == null){
            this.capaian_06 = 0;
        }
        if(this.capaian_06>120){
            this.capaian_06 = 120;
        }
        if(this.capaian_06 >= 100){
            this.color_06 = this.color_succes;
        }else if(this.capaian_06<100 && this.capaian_06>=50){
            this.color_06 = this.color_warning;
        }else if(this.capaian_06<50){
            this.color_06 = this.color_error;
        }
         // bulan
        if(this.capaian_07 == null && bulan_sekarang>7){
            this.capaian_07 = 100;
        }else if(this.capaian_07 == null){
            this.capaian_07 = 0;
        }
        if(this.capaian_07>120){
            this.capaian_07 = 120;
        }
        if(this.capaian_07 >= 100){
            this.color_07 = this.color_succes;
        }else if(this.capaian_07<100 && this.capaian_07>=50){
            this.color_07 = this.color_warning;
        }else if(this.capaian_07<50){
            this.color_07 = this.color_error;
        }
         // bulan
        if(this.capaian_08 == null && bulan_sekarang>8){
            this.capaian_08 = 100;
        }else if(this.capaian_08 == null){
            this.capaian_08 = 0;
        }
        if(this.capaian_08>120){
            this.capaian_08 = 120;
        }
        if(this.capaian_08 >= 100){
            this.color_08 = this.color_succes;
        }else if(this.capaian_08<100 && this.capaian_08>=50){
            this.color_08 = this.color_warning;
        }else if(this.capaian_08<50){
            this.color_08 = this.color_error;
        }
         // bulan
        if(this.capaian_09 == null && bulan_sekarang>9){
            this.capaian_09 = 100;
        }else if(this.capaian_09 == null){
            this.capaian_09 = 0;
        }
        if(this.capaian_09>120){
            this.capaian_09 = 120;
        }
        if(this.capaian_09 >= 100){
            this.color_09 = this.color_succes;
        }else if(this.capaian_09<100 && this.capaian_09>=50){
            this.color_09 = this.color_warning;
        }else if(this.capaian_09<50){
            this.color_09 = this.color_error;
        }
         // bulan
        if(this.capaian_10 == null && bulan_sekarang>10){
            this.capaian_10 = 100;
        }else if(this.capaian_10 == null){
            this.capaian_10 = 0;
        }
        if(this.capaian_10>120){
            this.capaian_10 = 120;
        }
        if(this.capaian_10 >= 100){
            this.color_10 = this.color_succes;
        }else if(this.capaian_10<100 && this.capaian_10>=50){
            this.color_10 = this.color_warning;
        }else if(this.capaian_10<50){
            this.color_10 = this.color_error;
        }
         // bulan
        if(this.capaian_11 == null && bulan_sekarang>11){
            this.capaian_11 = 100;
        }else if(this.capaian_11 == null){
            this.capaian_11 = 0;
        }
        if(this.capaian_11>120){
            this.capaian_11 = 120;
        }
        if(this.capaian_11 >= 100){
            this.color_11 = this.color_succes;
        }else if(this.capaian_11<100 && this.capaian_11>=50){
            this.color_11 = this.color_warning;
        }else if(this.capaian_11<50){
            this.color_11 = this.color_error;
        }
         // bulan
        if(this.capaian_12 == null && bulan_sekarang>12){
            this.capaian_12 = 100;
        }else if(this.capaian_12 == null){
            this.capaian_12 = 0;
        }
        if(this.capaian_12>120){
            this.capaian_12 = 120;
        }
        if(this.capaian_12 >= 100){
            this.color_12 = this.color_succes;
        }else if(this.capaian_12<100 && this.capaian_12>=50){
            this.color_12 = this.color_warning;
        }else if(this.capaian_12<50){
            this.color_12 = this.color_error;
        }
         // bulan
        if(this.capaian_total == null){
            this.capaian_total = 0;
        }
        if(this.capaian_total>120){
            this.capaian_total = 120;
        }
        if(this.capaian_total >= 100){
            this.color_total = this.color_succes;
        }else if(this.capaian_total<100 && this.capaian_total>=50){
            this.color_total = this.color_warning;
        }else if(this.capaian_total<50){
            this.color_total = this.color_error;
        }
    }
}