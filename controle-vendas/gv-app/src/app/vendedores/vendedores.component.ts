import {AfterViewInit, Component, ElementRef, OnInit, ViewChild} from '@angular/core';
import {Vendedor} from './vendedor.model';
import {VendedoresService} from './vendedores.service';
import {Observable} from 'rxjs';

@Component({
  selector: 'gv-vendedores',
  templateUrl: './vendedores.component.html'
})
export class VendedoresComponent implements OnInit, AfterViewInit {

  @ViewChild('filtro', {read: ElementRef}) filtro: ElementRef;
  vendedores: Observable<Vendedor[]>;

  constructor(private vendedoresService: VendedoresService) {
  }

  ngOnInit() {
    this.vendedores = this.vendedoresService.buscar('');
  }

  filtrarVendedores(filtro: string) {
    this.vendedores = this.vendedoresService.buscar(filtro);
  }

  limparFiltros() {
    this.vendedores = this.vendedoresService.buscar('');
    this.filtro.nativeElement.value = '';
    this.filtro.nativeElement.focus();
  }

  ngAfterViewInit(): void {
    this.filtro.nativeElement.focus();
  }
}
