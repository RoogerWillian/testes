import {Component, OnInit} from '@angular/core';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {Router} from '@angular/router';
import {VendasService} from '../vendas.service';
import {VendedoresService} from '../../vendedores/vendedores.service';
import {Vendedor} from '../../vendedores/vendedor.model';
import {Observable} from 'rxjs';
import {Venda} from '../venda.model';

declare var $: any;

@Component({
  selector: 'gv-nova-venda',
  templateUrl: './nova-venda.component.html'
})
export class NovaVendaComponent implements OnInit {

  vendaForm: FormGroup;
  numberPattern = /^[0-9]*$/;
  dataAtual = new Date();
  vendedores: Observable<Vendedor[]>;

  constructor(private router: Router, private formBuilder: FormBuilder,
              private vendasService: VendasService,
              private vendedorService: VendedoresService) {
  }

  ngOnInit() {
    this.vendedores = this.vendedorService.buscar('');

    this.vendaForm = this.formBuilder.group({
      valor: this.formBuilder.control('', [Validators.required, Validators.pattern(this.numberPattern)]),
      vendedor_id: this.formBuilder.control('', [Validators.required])
    });
  }

  lancarVenda(venda: Venda) {
    $('#botaoLancarVenda').button('loading');
    this.vendasService.lancarVenda(venda).subscribe(() => {
      this.router.navigate(['/vendas']);
      $('#botaoLancarVenda').button('reset');
    });
  }
}
