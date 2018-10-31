import {Component, OnInit} from '@angular/core';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {RelatorioService} from './relatorio.service';
import {RelatorioLogEnvioEmail} from './relatorio-logs-envio-email/relatorio-logs-envio-email.model';
import {Router} from '@angular/router';
import {MessagesService} from '../messages.service';

declare var $: any;

@Component({
  selector: 'gv-relatorios',
  templateUrl: './relatorios.component.html'
})
export class RelatoriosComponent implements OnInit {

  relatorioForm: FormGroup;
  logsEnvioEmail: RelatorioLogEnvioEmail[];
  emailPattern = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;

  constructor(private formBuilder: FormBuilder, private relatorioService: RelatorioService,
              private messageService: MessagesService) {

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
    if (email) {
      let campoEmail = $('#email');
      let helpBlock = $('.help-block');
      let botaoEnviar = $('#botaoEnviarEmail');
      botaoEnviar.button('loading');
      this.relatorioService.vendasDiarias(email).subscribe(() => {
        botaoEnviar.button('reset');
        campoEmail.parent().parent().removeClass('has-success');
        helpBlock.addClass('hidden');
        campoEmail.val('');
        campoEmail.focus();
        this.recuperarLogs();
        this.messageService.exibirMensagemSucesso('Relatório', 'E-mail enviado com sucesso!', 3000);
      });
    } else {
      alert('aaa');
    }
  }

  recuperarLogs() {
    this.relatorioService.logsDeEnvioDeEmail().subscribe(logs => {
      this.logsEnvioEmail = logs;
    });
  }
}
