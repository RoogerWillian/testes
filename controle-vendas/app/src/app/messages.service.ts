import {OnInit} from '@angular/core';
import iziToast from 'izitoast';

export class MessagesService implements OnInit {

  constructor() {
  }

  ngOnInit() {
  }

  exibirMensagemSucesso(titulo: string, message: string, tempo: number) {
    iziToast.success({
      title: titulo,
      message: message,
      position: 'topCenter',
      close: true,
      transitionIn: 'bounceInRight',
      progressBar: true,
      icon: 'fa fa-check-circle-o',
      timeout: tempo
    });
  }

}
