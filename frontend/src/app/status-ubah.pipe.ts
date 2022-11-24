import { Pipe, PipeTransform } from '@angular/core';
import {Capaian_Individu_Pair_DL} from './Object/Object';

@Pipe({
  name: 'statusUbah'
})
export class StatusUbahPipe implements PipeTransform {

  transform(items: Capaian_Individu_Pair_DL[], filter: Object):  Capaian_Individu_Pair_DL[]{
    if (!items || !filter) {
        return items;
    }
    // filter items array, items which match and return true will be
    // kept, false will be filtered out
    return items.filter(item => item.status_ubah !== '2');
  }
}
