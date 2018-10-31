import {Component, Input, OnInit} from '@angular/core';
import {RelatorioLogEnvioEmail} from './relatorio-logs-envio-email.model';

@Component({
  selector: 'gv-relatorio-logs-envio-email',
  templateUrl: './relatorio-logs-envio-email.component.html'
})
export class RelatorioLogsEnvioEmailComponent implements OnInit {

  @Input() logs: RelatorioLogEnvioEmail[];

  constructor() {
  }

  ngOnInit() {
  }

}
