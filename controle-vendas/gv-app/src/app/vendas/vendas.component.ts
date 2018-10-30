import {Component, OnInit} from '@angular/core';
import {VendasService} from './vendas.service';
import {Venda} from './venda.model';
import {Observable} from 'rxjs';
import {VendedoresService} from '../vendedores/vendedores.service';
import {Vendedor} from '../vendedores/vendedor.model';
import {ActivatedRoute, Router} from '@angular/router';

@Component({
  selector: 'gv-vendas',
  templateUrl: './vendas.component.html'
})
export class VendasComponent implements OnInit {

  vendas: Observable<Venda[]>;
  vendedores: Observable<Vendedor[]>;

  constructor(private vendasService: VendasService, private vendedoresService: VendedoresService,
              private router: ActivatedRoute) {
  }

  ngOnInit() {
    this.vendas = this.vendasService.porVendendor(this.getIdVendedorRoute() !== undefined ? this.getIdVendedorRoute() : '');
    this.vendedores = this.vendedoresService.buscar('');
  }

  onVendedorSelecionado(id: string) {
    this.vendas = this.vendasService.porVendendor(id);
  }

  getIdVendedorRoute(): string {
    return this.router.snapshot.queryParams['id'];
  }
}
