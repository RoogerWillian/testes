import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Observable} from 'rxjs';
import {Vendedor} from './vendedor.model';
import {GV_API} from '../app.api';

@Injectable()
export class VendedoresService {

  constructor(private http: HttpClient) {
  }

  buscar(): Observable<Vendedor[]> {
    console.log(`${GV_API}/vendedores`);
    return this.http.get<Vendedor[]>(`${GV_API}/vendedores`);
  }
}
