import {Component, OnInit} from '@angular/core';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {Router} from '@angular/router';
import {VendasService} from '../vendas.service';
import {VendedoresService} from '../../vendedores/vendedores.service';
import {Vendedor} from '../../vendedores/vendedor.model';
import {Observable} from 'rxjs';
import {Venda} from '../venda.model';
import {UdpCurrencyMaskPipe} from '../../pipe/currency.pipe';
import {CurrencyPipe} from '@angular/common';

declare var $: any;

@Component({
  selector: 'gv-nova-venda',
  templateUrl: './nova-venda.component.html'
})
export class NovaVendaComponent implements OnInit {

  vendaForm: FormGroup;
  numberPattern = /\d{1,3}(?:\.\d{2,3})*?,\d/;
  dataAtual = new Date();
  vendedores: Observable<Vendedor[]>;

  constructor(private router: Router, private formBuilder: FormBuilder,
              private vendasService: VendasService,
              private vendedorService: VendedoresService) {
  }

  ngOnInit() {
    $('#valor').mask('#.##0,00', {reverse: true});

    this.vendedores = this.vendedorService.buscar('');
    this.vendaForm = this.formBuilder.group({
      valor: this.formBuilder.control('', [
        Validators.required, Validators.pattern(this.numberPattern),
        Validators.maxLength(10)
      ]),
      vendedor_id: this.formBuilder.control('', [Validators.required])
    });
  }

  lancarVenda(venda: Venda) {
    venda.valor = $('#valor').unmask().mask('#.##0,00', {reverse: true}).val();

    $('#botaoLancarVenda').button('loading');
    this.vendasService.lancarVenda(venda).subscribe(() => {
      this.router.navigate(['/vendas']);
      $('#botaoLancarVenda').button('reset');
    });
  }
}
