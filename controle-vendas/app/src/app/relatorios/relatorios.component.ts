import {Component, OnInit} from '@angular/core';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {RelatorioService} from './relatorio.service';

declare var $: any;

@Component({
  selector: 'gv-relatorios',
  templateUrl: './relatorios.component.html'
})
export class RelatoriosComponent implements OnInit {

  relatorioForm: FormGroup;
  emailPattern = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;

  constructor(private formBuilder: FormBuilder, private relatorioService: RelatorioService) {

  }

  ngOnInit() {
    this.relatorioForm = this.formBuilder.group({
      email: this.formBuilder.control('', [Validators.required, Validators.pattern(this.emailPattern)])
    });
  }

  enviarEmailVendasDiarias(email: string) {
    $('#botaoEnviarEmail').button('loading');
    this.relatorioService.vendasDiarias(email).subscribe(() => {
      $('#botaoEnviarEmail').button('reset');
    });
  }

}
