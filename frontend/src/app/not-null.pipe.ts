import { Pipe, PipeTransform } from '@angular/core';
import {Capaian_Individu} from './Object/Object';

@Pipe({
  name: 'notNull'
})
export class NotNullPipe implements PipeTransform {

  transform(items: Capaian_Individu[]):  Capaian_Individu[]{
    if (!items) {
        return items;
    }
    // filter items array, items which match and return true will be
    // kept, false will be filtered out
    return items.filter(item => item.nip_lama != null);
  }

}
