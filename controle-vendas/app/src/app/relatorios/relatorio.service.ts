import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {GV_API} from '../app.api';
import {Observable} from 'rxjs';

@Injectable()
export class RelatorioService {

  constructor(private http: HttpClient) {
  }

  vendasDiarias(email: string): Observable<string> {
    return this.http.post<string>(`${GV_API}/relatorios/vendas_diarias`, email);
  }
}
