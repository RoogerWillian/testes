import {AfterViewInit, Component, Inject, OnInit} from '@angular/core';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {Router} from '@angular/router';
import {Vendedor} from '../vendedor.model';
import {VendedoresService} from '../vendedores.service';
import {DOCUMENT} from '@angular/common';

declare var $: any;

@Component({
  selector: 'gv-novo-vendedor',
  templateUrl: './novo-vendedor.component.html'
})
export class NovoVendedorComponent implements OnInit, AfterViewInit {

  vendedorForm: FormGroup;
  emailPattern = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;

  constructor(private router: Router, private formBuilder: FormBuilder,
              private vendedorService: VendedoresService) {
  }

  ngOnInit() {
    this.vendedorForm = this.formBuilder.group({
      nome: this.formBuilder.control('', [Validators.required]),
      email: this.formBuilder.control('', [Validators.required, Validators.pattern(this.emailPattern)])
    });
  }

  salvarVendedor(vendedor: Vendedor) {
    $('#botaoSalvarVendedor').button('loading');
    this.vendedorService.salvar(vendedor).subscribe(() => {
      $('#botaoSalvarVendedor').button('reset');
      this.router.navigate(['/vendedores']);
    });
  }

  ngAfterViewInit(): void {
  }
}
