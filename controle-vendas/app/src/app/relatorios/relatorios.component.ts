import {Component, OnInit} from '@angular/core';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {RelatorioService} from './relatorio.service';
import {RelatorioLogEnvioEmail} from './relatorio-logs-envio-email/relatorio-logs-envio-email.model';
import {Router} from '@angular/router';

declare var $: any;

@Component({
  selector: 'gv-relatorios',
  templateUrl: './relatorios.component.html'
})
export class RelatoriosComponent implements OnInit {

  relatorioForm: FormGroup;
  logsEnvioEmail: RelatorioLogEnvioEmail[];
  emailPattern = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;

  constructor(private formBuilder: FormBuilder, private relatorioService: RelatorioService) {

  }

  ngOnInit() {
    // Configurando formulario
    this.relatorioForm = this.formBuilder.group({
      email: this.formBuilder.control('', [Validators.required, Validators.pattern(this.emailPattern)])
    });

    // Recuperando logs de envio de emails
    this.recuperarLogs();
  }

  enviarEmailVendasDiarias(email: string) {
    let campoEmail = $('#email');
    let helpBlock = $('.help-block');
    $('#botaoEnviarEmail').button('loading');
    this.relatorioService.vendasDiarias(email).subscribe(() => {
      $('#botaoEnviarEmail').button('reset');
      campoEmail.parent().parent().removeClass('has-success');
      helpBlock.addClass('hidden');
      campoEmail.val('');
      campoEmail.focus();
    });
  }

  recuperarLogs() {
    this.relatorioService.logsDeEnvioDeEmail().subscribe(logs => {
      this.logsEnvioEmail = logs;
    });
  }
}
