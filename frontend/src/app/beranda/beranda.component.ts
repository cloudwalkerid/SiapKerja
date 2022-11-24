import { Component, OnInit } from '@angular/core';
import { MyDataService } from '../my-data.service';
import { Kegiatan } from '../Object/Object';
import { Beranda_Helper } from '../Object/Beranda_Helper';
import { interval } from 'rxjs';
import { NgxSpinnerService } from 'ngx-spinner';
import { ChartDataSets, ChartOptions, ChartType } from 'chart.js';
import { Color, BaseChartDirective, Label } from 'ng2-charts';

declare var $: any;

@Component({
  selector: 'app-beranda',
  templateUrl: './beranda.component.html',
  styleUrls: ['./beranda.component.css']
})
export class BerandaComponent implements OnInit {

  public barChartData: ChartDataSets[] = [{
    label: 'Capaian',
    data: [],
    borderWidth: 2,
    backgroundColor: [],
    borderColor: 'transparent',
    pointBorderWidth: 0 ,
    pointRadius: 3.5,
    pointBackgroundColor: 'transparent',
    pointHoverBackgroundColor: 'rgba(254,86,83,.8)',
  }];
  public barChartLabels: Label[] = [];
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
  public pieChartDataSatker: number[] = [0, 0];
  public pieChartDataBulan: number[] = [0, 0];
  public pieChartType: ChartType = 'pie';
  public pieChartLegend = true;
  public pieChartColorsSatker = [
    {
      backgroundColor: ['rgba(0,255,0,0.3)', 'rgba(0,255,0,0)'],
      borderColor: ['rgb(192,192,192,.8)', 'rgb(192,192,192,.8)'],
    },
  ];
  public pieChartColorsBulan = [
    {
      backgroundColor: ['rgba(0,255,0,0.3)', 'rgba(0,255,0,0)'],
      borderColor: ['rgb(192,192,192,.8)', 'rgb(192,192,192,.8)'],
    },
  ];

  kegiatans: Kegiatan[] = [];
  berandaHelper: Beranda_Helper;

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
    this.myData.getBeranda().subscribe({
      next: data => this.processData(data),
      error: error => console.error('Error get Kegiatan', error)
    });
  }

  processData(data: any): void{
    this.kegiatans = [];
    data.forEach(element => {
      let itemKegiatan = new Kegiatan();
      itemKegiatan.setData(element);
      this.kegiatans.push(itemKegiatan);
    });
    this.berandaHelper = new Beranda_Helper();
    this.berandaHelper.setData(this.myData.all_seksi, this.kegiatans);

    let indexABC = 0;
    console.log(this.berandaHelper);
    this.berandaHelper.seksiHelper.forEach((element, inndex )=> {
      if(element.seksi.id != this.myData.kepala_seksi){
        this.barChartLabels[indexABC] = element.seksi.nama;
        this.barChartData[0].data[indexABC] =  parseFloat(element.getCapainBulan(this.bulan_index).toFixed(2));
        this.barChartData[0].backgroundColor[indexABC] = element.getColorBulanA(this.bulan_index);
        indexABC = indexABC + 1;
      }
    });

    this.pieChartDataSatker = [parseFloat(this.berandaHelper.satkerHelper.capaian_total.toFixed(2))
      , parseFloat((100 - this.berandaHelper.satkerHelper.capaian_total).toFixed(2))];
    if(this.berandaHelper.satkerHelper.capaian_total >= 100){
        this.pieChartColorsSatker[0]['backgroundColor'][0] = this.myData.color_succes;
    }else if(this.berandaHelper.satkerHelper.capaian_total<100 && this.berandaHelper.satkerHelper.capaian_total>=50){
      this.pieChartColorsSatker[0]['backgroundColor'][0] = this.myData.color_warning
    }else if(this.berandaHelper.satkerHelper.capaian_total<50){
      this.pieChartColorsSatker[0]['backgroundColor'][0] = this.myData.color_error
    }
    this.pieChartDataBulan = [parseFloat(this.berandaHelper.getCapainBulan(this.bulan_index).toFixed(2))
      , parseFloat((100 - this.berandaHelper.getCapainBulan(this.bulan_index)).toFixed(2))];
    if(this.berandaHelper.getCapainBulan(this.bulan_index) >= 100){
        this.pieChartColorsBulan[0]['backgroundColor'][0] = this.myData.color_succes;
    }else if(this.berandaHelper.getCapainBulan(this.bulan_index)<100 && this.berandaHelper.getCapainBulan(this.bulan_index)>=50){
      this.pieChartColorsBulan[0]['backgroundColor'][0] = this.myData.color_warning
    }else if(this.berandaHelper.getCapainBulan(this.bulan_index)<50){
      this.pieChartColorsBulan[0]['backgroundColor'][0] = this.myData.color_error
    }
    this.spinner.hide();
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
  onClickBarChart(): void{

  }
}
