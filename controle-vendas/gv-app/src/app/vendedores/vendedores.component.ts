import {Component, OnInit} from '@angular/core';
import {Vendedor} from './vendedor.model';
import {VendedoresService} from './vendedores.service';
import {Observable} from 'rxjs';

@Component({
  selector: 'gv-vendedores',
  templateUrl: './vendedores.component.html'
})
export class VendedoresComponent implements OnInit {

  vendedores: Observable<Vendedor[]>;

  constructor(private vendedoresService: VendedoresService) {
  }

  ngOnInit() {
    this.vendedores = this.vendedoresService.buscar();
  }

}
