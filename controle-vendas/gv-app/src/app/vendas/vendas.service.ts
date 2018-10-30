import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Observable} from 'rxjs';
import {Venda} from './venda.model';
import {GV_API} from '../app.api';

@Injectable()
export class VendasService {

  statusBusca = false;

  constructor(private http: HttpClient) {
  }

  porVendendor(idVendedor: string): Observable<Venda[]> {
    this.atualizarStatusBusca(true);
    return this.http.get<Venda[]>(`${GV_API}/vendas/por_vendedor/${idVendedor}`)
  }

  lancarVenda(venda: Venda) {
    return this.http.post<Venda>(`${GV_API}/vendas/lancar`, venda);
  }

  isBuscando(): boolean {
    return this.statusBusca;
  }

  atualizarStatusBusca(status: boolean) {
    this.statusBusca = status;
  }
}
