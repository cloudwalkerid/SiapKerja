import { Inject, Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpParams} from '@angular/common/http';
import { Meta } from '@angular/platform-browser';
import { User, Seksi, Kegiatan, Kegiatan_PJ, Tahapan_Kegiatan, Capaian_Tahapan, Capaian_Individu, DL, Tahapan_Alokasi_DL, Capaian_Individu_Pair_DL, CKP_Item } from './Object/Object';
import { Observable, of, interval} from 'rxjs';




@Injectable({
  providedIn: 'root'
})


export class MyDataService {

  csrf_token: string = this.meta.getTag('name= _token').content;
  baseHref: string = this.meta.getTag('name= base_url').content;

  headers = new HttpHeaders();
  myUser: User;
  mySeksi: Seksi;
  myKegiatan: Kegiatan [] =  [];
  all_seksi: Seksi[] = [];

  kepala_seksi: string = "";
  user_is_kepala: boolean = false;

  color_succes: string = "rgb(71, 195, 99, .7)";
  color_warning: string = "rgb(255, 164, 38, .7)";
  color_error: string = "rgb(252, 84, 75, .7)"

  // bulan_aktive: number = (new Date()).getMonth() + 1;
  // tahun_aktive: number = (new Date()).getFullYear();
  bulan_aktive: number = 9;
  tahun_aktive: number = 2020;

  constructor(private http: HttpClient, private meta: Meta) {
    let minuteCounter = interval(10 * 60 * 1000);
    this.headers.set('X-CSRF-Token', this.csrf_token);
    // console.log(this.csrf_token);
    this.showmyKegiatan();
    minuteCounter.subscribe(n =>
      this.showmyKegiatan());
  }


  setUser(data: any): void{
    this.myUser = new User();
    this.myUser.setData(data);
    this.mySeksi = this.myUser.seksi;
  }

  setSeksi(data: any): void{
    this.all_seksi = [];
    data.forEach(element => {
      let itemSeksi = new Seksi();
      itemSeksi.setData(element);
      this.all_seksi.push(itemSeksi);
    });
  }
   // lihat beranda
  getBeranda(): Observable<any>{
    return this.http.post(this.baseHref+'/home', {headers: this.headers, responseType: 'json'});
  }
  getSeksi(): Observable<any>{
    return this.http.post(this.baseHref+'/seksi', {headers: this.headers, responseType: 'json'});
  }
  getIndividu(): Observable<any>{
    return this.http.post(this.baseHref+'/individu', {headers: this.headers, responseType: 'json'});
  }

  // Kegiatan

  showmyKegiatan(): void{
    const options = {headers: this.headers };
    this.http.post(this.baseHref+'/kegiatan/get', options)
      .subscribe({
        next: data => this.processDataKegiatan(data),
        error: error => this.errorProcess(error)
      });
  }

  processDataKegiatan(data: any): void{
    // console.log(data);
    this.myKegiatan = [];
    data.forEach(element => {
      let kegiatan = new Kegiatan();
      kegiatan.setData(element);
      this.myKegiatan.push(kegiatan);
    });
  }
  errorProcess(error): void{
    if(error['status'] = 401){
      window.location.href = this.baseHref+"/logout";
    }
  }

  getKegiatan(idKegiatan: string): Observable<any>{
    return this.http.post(this.baseHref+'/kegiatan/' + idKegiatan , {headers: this.headers, responseType: 'json'});
  }

  createKegiatan(kegiatan: Kegiatan): Observable<string>{
    return this.http.post(this.baseHref+'/kegiatan/create', kegiatan, {headers: this.headers, responseType: 'text'});
  }

  updateKegiatan(kegiatan: Kegiatan): Observable<string>{
    return this.http.post(this.baseHref+'/kegiatan/' + kegiatan.id + '/update', kegiatan, { headers: this.headers , responseType: 'text'});
  }

  deleteKegiatan(kegiatan: Kegiatan): Observable<string>{
    return this.http.post(this.baseHref+'/kegiatan/' + kegiatan.id + '/delete', kegiatan, { headers: this.headers , responseType: 'text'});
  }

  // Tahapan
  createTahapanKegiatan(tahapan: Tahapan_Kegiatan): Observable<any>{
    return this.http.post(this.baseHref+'/kegiatan/' + tahapan.kegiatan_id + '/tahapan/create'
      , tahapan,  {headers: this.headers, responseType: 'json'});
  }


  updateTahapanKegiatan(tahapan: Tahapan_Kegiatan): Observable<string>{
    return this.http.post(this.baseHref+'/kegiatan/' + tahapan.kegiatan_id + '/tahapan/' + tahapan.id + '/update'
      , tahapan,  {headers: this.headers, responseType: 'text'});
  }

  deleteTahapanKegiatan(tahapan: Tahapan_Kegiatan): Observable<string>{
    return this.http.post(this.baseHref+'/kegiatan/' + tahapan.kegiatan_id + '/tahapan/' + tahapan.id + '/delete'
      , tahapan,  {headers: this.headers, responseType: 'text'});
  }

  startTahapanKegiatan(tahapan: Tahapan_Kegiatan): Observable<string>{
    return this.http.post(this.baseHref+'/kegiatan/' + tahapan.kegiatan_id + '/tahapan/' + tahapan.id + '/start'
      , tahapan,  {headers: this.headers, responseType: 'text'});
  }

  stopTahapanKegiatan(tahapan: Tahapan_Kegiatan): Observable<string>{
    return this.http.post(this.baseHref+'/kegiatan/' + tahapan.kegiatan_id + '/tahapan/' + tahapan.id + '/stop'
      , tahapan,  {headers: this.headers, responseType: 'text'});
  }
  // Tahpan Alokasi
  getTahapanKegiatan(kegiatan_id: string, tahapan_id: string): Observable<any>{
    return this.http.post(this.baseHref+'/kegiatan/' + kegiatan_id + '/tahapan/' + tahapan_id + '/show'
      ,  {headers: this.headers, responseType: 'json'});
  }

  tahapanAlokasiKegiatan(tahapan_kegiatan: Tahapan_Kegiatan): Observable<string>{
    tahapan_kegiatan.hitungCapaianTahapan();
    tahapan_kegiatan.deleteUser();
    let pairAll: Capaian_Individu_Pair_DL [] = [];
    pairAll  = pairAll.concat(tahapan_kegiatan.capaianIndividuPairDL).concat(tahapan_kegiatan.deletedCapaianIndividuPairDL);
    let data = {'capaian_tahapan': tahapan_kegiatan.capaian_tahapan, 'pair' : pairAll };
    return this.http.post(this.baseHref+'/kegiatan/' + tahapan_kegiatan.kegiatan_id + '/tahapan/' + tahapan_kegiatan.id + '/alokasi'
      , data,  {headers: this.headers, responseType: 'text'});
  }
  // capaian
  getCapaian(): Observable<any>{
    return this.http.post(this.baseHref+'/capaian/get',  {headers: this.headers, responseType: 'json'});
  }

  updateCapaianTahapan(capaian_tahapan: Capaian_Tahapan): Observable<string>{
    return this.http.post(this.baseHref+'/capaian/seksi/' + capaian_tahapan.id + '/update', capaian_tahapan
      ,  {headers: this.headers, responseType: 'text'});
  }

  updateCapaianIndividu(capaian_individu: Capaian_Individu): Observable<string>{
    return this.http.post(this.baseHref+'/capaian/individu/' + capaian_individu.id + '/update', capaian_individu
      ,  {headers: this.headers, responseType: 'text'});
  }

  // ckp
  // target
  getCKP(month: number, year: number): Observable<any>{
    return this.http.post(this.baseHref+'/ckp/show/' + month + '/' + year,  {headers: this.headers, responseType: 'json'});
  }
  getCKPTGet(month: number, year: number): Observable<any>{
    return this.http.post(this.baseHref+'/ckp/ckp_t/' + month + '/' + year + '/create/get',  {headers: this.headers, responseType: 'json'});
  }
  getCKPTSubmit(month: number, year: number, yang_ttd: string, ckpItem: CKP_Item[]): Observable<string>{
    let data = {'nip_lama': yang_ttd, 'data': ckpItem}
    return this.http.post(this.baseHref+'/ckp/ckp_t/' + month + '/' + year + '/create/submit', data,  {headers: this.headers, responseType: 'text'});
  }
  // realisasi
  getCKPRAdd(month: number, year: number, ckpItem: CKP_Item): Observable<string>{
    return this.http.post(this.baseHref+'/ckp/ckp_r/' + month + '/' + year + '/add', ckpItem
      ,  {headers: this.headers, responseType: 'text'});
  }
  getCKPRUpdate(month: number, year: number, idItem: string, realisasi: number): Observable<string>{
    let data = {'realisasi': realisasi}
    return this.http.post(this.baseHref+'/ckp/ckp_r/' + month + '/' + year + '/update/'+idItem, data,  {headers: this.headers, responseType: 'text'});
  }
  getCKPRDelete(month: number, year: number, data: any, idItem: string): Observable<string>{
    return this.http.post(this.baseHref+'/ckp/ckp_r/' + month + '/' + year + '/delete'+idItem, data,  {headers: this.headers, responseType: 'text'});
  }
  getCKPRSubmit(month: number, year: number, yang_ttd: string): Observable<string>{
    let data = {'nip_lama': yang_ttd}
    return this.http.post(this.baseHref+'/ckp/ckp_r/' + month + '/' + year + '/submit', data , {headers: this.headers, responseType: 'text'});
  }
  geCKPTText(month: number, year: number): Observable<string>{
    return this.http.post(this.baseHref+'/ckp/print/target/'+month+'/'+year, null, {headers: this.headers, responseType: 'text'});
  }
  // dl
  getDL(month: string, year: string): Observable<any>{
    return this.http.post(this.baseHref+'/dl/get/' + month + '/' + year,  {headers: this.headers, responseType: 'json'});
  }
  getDLLainnya(month: string, year: string, user: User): Observable<any>{
    return this.http.post(this.baseHref+'/dl/get/' + month + '/' + year + '/' + user.nip_lama
      ,  {headers: this.headers, responseType: 'json'});
  }
  getUpdateDL(month: string, year: string, idAlokasiKegiatanTahapan: string, dl: DL): Observable<string>{
    return this.http.post(this.baseHref+'/dl/update_dl/' + idAlokasiKegiatanTahapan , dl, {headers: this.headers, responseType: 'text'});
  }
  // lainnya
  getUser(): Observable<any>{
    return this.http.post(this.baseHref+'/getListUser', {headers: this.headers, responseType: 'json'});
  }
  addNewPJ(newPJ: Kegiatan_PJ): Observable<string>{
    return this.http.post(this.baseHref+'/kegiatan/' + newPJ.kegiatan_id + '/addNewPJ'
      , newPJ, {headers: this.headers, responseType: 'text'});
  }
  deletePJ(newPJ: Kegiatan_PJ): Observable<string>{
    return this.http.post(this.baseHref+'/kegiatan/' + newPJ.kegiatan_id + '/deleteNewPJ', newPJ, {headers: this.headers, responseType: 'text'});
  }
  getMitra(): Observable<any>{
    return this.http.post(this.baseHref+'/getListMitra', {headers: this.headers, responseType: 'json'});
  }
  getDataReferensi(): Observable<any>{
    return this.http.post(this.baseHref+'/getListReferensi', {headers: this.headers, responseType: 'text'});
  }
  downloadCKPTarget(month: number, year: number): Observable<Blob>{
    return this.http.get(this.baseHref+"/ckp/print/target/"+month+"/"+year, { headers: this.headers, responseType: 'blob' });
  }

  downloadCKPRealisasi(month: number, year: number): Observable<Blob>{
    return this.http.get(this.baseHref+"/ckp/print/realisasi/"+month+"/"+year, { headers: this.headers, responseType: 'blob' });
  }
}
