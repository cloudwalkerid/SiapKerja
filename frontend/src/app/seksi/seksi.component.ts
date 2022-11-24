import { Component, OnInit } from '@angular/core';
import { MyDataService } from '../my-data.service';
import { Kegiatan , Capaian_Individu, Capaian_Tahapan, Tahapan_Kegiatan} from '../Object/Object';
import { Beranda_Helper, Capaian_Seksi_Helper} from '../Object/Beranda_Helper';
import { interval } from 'rxjs';
import { NgxSpinnerService } from 'ngx-spinner';
import { ChartDataSets, ChartOptions, ChartType } from 'chart.js';
import { Label } from 'ng2-charts';
import { Router } from '@angular/router';
import { THIS_EXPR } from '@angular/compiler/src/output/output_ast';

declare var $: any;

@Component({
  selector: 'app-seksi',
  templateUrl: './seksi.component.html',
  styleUrls: ['./seksi.component.css']
})
export class SeksiComponent implements OnInit {

  public barChartData: ChartDataSets[] = [{
    label: 'Capaian',
    data: [0,0,0,0,0,0,0,0,0,0,0,0],
    borderWidth: 2,
    backgroundColor: [],
    borderColor: 'transparent',
    pointBorderWidth: 0 ,
    pointRadius: 3.5,
    pointBackgroundColor: 'transparent',
    pointHoverBackgroundColor: 'rgba(254,86,83,.8)',
  }];
  public barChartLabels: Label[] = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus'
    , 'September', 'Oktober', 'November', 'Desember'];
  public barChartOptions: ChartOptions = {
    responsive: true,
    // We use these empty structures as placeholders for dynamic theming.
    scales: { xAxes: [{}], yAxes: [{}] },
    plugins: {
      datalabels: {
        anchor: 'end',
        align: 'end',
      }
    }
  }
  public barChartLegend  = true;
  public barChartType: ChartType = 'horizontalBar';

  public pieChartOptions: ChartOptions = {
    responsive: true,
    legend: {
      position: 'top',
    },
    plugins: {
      datalabels: {
        formatter: (value, ctx) => {
          const label = ctx.chart.data.labels[ctx.dataIndex];
          return label;
        },
      },
    }
  };
  public pieChartLabels: Label[] = ['Realisasi', 'Tidak Realisasi'];
  public pieChartData: number[] = [0, 0];
  public pieChartType: ChartType = 'pie';
  public pieChartLegend = true;
  public pieChartColors = [
    {
      backgroundColor: ['rgba(0,255,0,0.3)', 'rgba(0,255,0,0)'],
      borderColor: ['rgb(192,192,192,.8)', 'rgb(192,192,192,.8)'],
    },
  ];

  kegiatans: Kegiatan[] = [];
  berandaHelper: Beranda_Helper;
  mySeksiHelper: Capaian_Seksi_Helper;

  kegiatanShow: Kegiatan[] = [];
  show = true;
  bulan_index: number = 0;

  constructor(public myData: MyDataService, private spinner: NgxSpinnerService, private router: Router) {
    this.bulan_index = myData.bulan_aktive;
    this.loadDataSeksi();
    let minuteCounter = interval(15 * 60 * 1000);
    minuteCounter.subscribe(n =>
      this.loadDataSeksi());
  }

  ngOnInit(): void {
  }

  loadDataSeksi(): void{
    this.spinner.show();
    this.myData.getSeksi().subscribe({
      next: data => this.processData(data),
      error: error => console.error('Error get Kegiatan', error)
    });
  }

  processData(data: any): void{
    this.kegiatans = [];
    this.kegiatanShow = [];
    data.forEach(element => {
      let itemKegiatan = new Kegiatan();
      itemKegiatan.setData(element);
      this.kegiatans.push(itemKegiatan);
    });
    this.berandaHelper = new Beranda_Helper();
    this.berandaHelper.setData(this.myData.all_seksi, this.kegiatans);
    let mySeksi = new Capaian_Seksi_Helper();
    if(this.myData.user_is_kepala){
      mySeksi = this.berandaHelper.satkerHelper;
    }else{
      this.berandaHelper.seksiHelper.forEach(element => {
        if(element.seksi.id == this.myData.myUser.seksi_id){
          mySeksi = element;
        }
      });
    }
    // console.log(mySeksi);
    this.barChartData[0].data = [parseFloat(mySeksi.capaian_01.toFixed(2)), parseFloat(mySeksi.capaian_02.toFixed(2))
      , parseFloat(mySeksi.capaian_03.toFixed(2)), parseFloat(mySeksi.capaian_04.toFixed(2))
      , parseFloat(mySeksi.capaian_05.toFixed(2)), parseFloat(mySeksi.capaian_06.toFixed(2))
      , parseFloat(mySeksi.capaian_07.toFixed(2)), parseFloat(mySeksi.capaian_08.toFixed(2))
      , parseFloat(mySeksi.capaian_09.toFixed(2)), parseFloat(mySeksi.capaian_10.toFixed(2))
      , parseFloat(mySeksi.capaian_11.toFixed(2)), parseFloat(mySeksi.capaian_12.toFixed(2))];
    this.barChartData[0].backgroundColor = [mySeksi.color_01, mySeksi.color_02, mySeksi.color_03, mySeksi.color_04
      , mySeksi.color_05, mySeksi.color_06, mySeksi.color_07, mySeksi.color_08
      , mySeksi.color_09, mySeksi.color_10, mySeksi.color_11, mySeksi.color_12];
    this.pieChartData = [parseFloat(mySeksi.capaian_total.toFixed(2)), parseFloat((100 - mySeksi.capaian_total).toFixed(2))];
    if(mySeksi.capaian_total >= 100){
        this.pieChartColors[0]['backgroundColor'][0] = this.myData.color_succes;
    }else if(mySeksi.capaian_total<100 && mySeksi.capaian_total>=50){
      this.pieChartColors[0]['backgroundColor'][0] = this.myData.color_warning
    }else if(mySeksi.capaian_total<50){
      this.pieChartColors[0]['backgroundColor'][0] = this.myData.color_error
    }
    this.kegiatans.forEach(elementKegiatan => {
      let masukkan = false;
      elementKegiatan.kegiatan_tahapan.forEach(element => {
        if(element.is_mulai == '1' && ((element.checkIfAktiveInBulan(this.bulan_index))
          || ((element.checkIfBelumPenuhInBulan(this.bulan_index))) && (element.capaian_total != 100))){
            masukkan = true;
        }
      });
      if(masukkan){
        this.kegiatanShow.push(elementKegiatan);
      }

    });
    this.kegiatanShow.sort(function(a,b):number{ return a.capaian_total - b.capaian_total});
    this.spinner.hide();
    this.reRenderTable();
  }
  checkIfCanDetail(itemKegiatan: Kegiatan): boolean{
    if(this.myData.user_is_kepala){
      return true;
    }else if(itemKegiatan.seksi_id == this.myData.myUser.seksi_id && (this.myData.myUser.is_kasi_plt == "1" || this.myData.myUser.is_kasi_plt == "2")){
      return true;
    }else if(itemKegiatan.checkIfuserPj(this.myData.myUser)){
      return true;
    }else{
      return false;
    }

  }
  seeDetailKegiatan(itemKegiatan: Kegiatan): void{
    this.router.navigate(['kegiatan/' + itemKegiatan.id ]);
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
