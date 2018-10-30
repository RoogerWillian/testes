import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Observable} from 'rxjs';
import {Vendedor} from './vendedor.model';
import {GV_API} from '../app.api';
import {ErrorHandler} from '../app.error-handler';

@Injectable()
export class VendedoresService {

  constructor(private http: HttpClient) {
  }

  buscar(filtro: string): Observable<Vendedor[]> {
    return this.http.get<Vendedor[]>(`${GV_API}/vendedores?filtro=${filtro}`).catch(ErrorHandler.handleError);
  }

  salvar(vendedor: Vendedor): Observable<Vendedor> {
    return this.http.post<Vendedor>(`${GV_API}/vendedores`, vendedor);
  }
}
