import {Component, OnInit} from '@angular/core';
import {VendasService} from './vendas.service';
import {Venda} from './venda.model';
import {Observable} from 'rxjs';
import {VendedoresService} from '../vendedores/vendedores.service';
import {Vendedor} from '../vendedores/vendedor.model';

@Component({
  selector: 'gv-vendas',
  templateUrl: './vendas.component.html'
})
export class VendasComponent implements OnInit {

  vendas: Observable<Venda[]>;
  vendedores: Observable<Vendedor[]>;

  constructor(private vendasService: VendasService, private vendedoresService: VendedoresService) {
  }

  ngOnInit() {
    this.vendas = this.vendasService.porVendendor('');
    this.vendedores = this.vendedoresService.buscar('');
  }

  onVendedorSelecionado(id: string) {
    this.vendas = this.vendasService.porVendendor(id);
  }
}
