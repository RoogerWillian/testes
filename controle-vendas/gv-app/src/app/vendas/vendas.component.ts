import {Component, OnInit} from '@angular/core';
import {VendasService} from './vendas.service';
import {Venda} from './venda.model';
import {Observable} from 'rxjs';
import {VendedoresService} from '../vendedores/vendedores.service';
import {Vendedor} from '../vendedores/vendedor.model';
import {ActivatedRoute, Router} from '@angular/router';

declare var $: any;

@Component({
  selector: 'gv-vendas',
  templateUrl: './vendas.component.html'
})
export class VendasComponent implements OnInit {

  vendas: Venda[];
  vendedores: Observable<Vendedor[]>;

  constructor(private vendasService: VendasService, private vendedoresService: VendedoresService,
              private router: ActivatedRoute) {
  }

  ngOnInit() {
    this.vendasService.porVendendor(this.getIdVendedorRoute() !== undefined ? this.getIdVendedorRoute() : '')
      .subscribe(vendas => {
        this.vendas = vendas;
        this.vendasService.atualizarStatusBusca(false);
      });
    this.vendedores = this.vendedoresService.buscar('');

    this.inicializarSelect2();
    this.startEventoChangeFiltro();
  }

  onVendedorSelecionado(id: string) {
    this.vendasService.porVendendor(id).subscribe(vendas => {
      this.vendas = vendas;
      this.vendasService.atualizarStatusBusca(false);
    });
  }

  getIdVendedorRoute(): string {
    return this.router.snapshot.queryParams['id'];
  }

  isBuscandoVendas(): boolean {
    return this.vendasService.isBuscando();
  }

  startEventoChangeFiltro() {
    $('#vendedor_filtro').on('change', e => {
      let current_value = $(e.currentTarget).val();
      this.onVendedorSelecionado(current_value);
    });
  }

  inicializarSelect2() {
    $('.vendedor_filtro').select2({
      theme: 'bootstrap'
    });

    $('.select2-selection__rendered').css({top: '4px', position: 'relative'});
  }

}
