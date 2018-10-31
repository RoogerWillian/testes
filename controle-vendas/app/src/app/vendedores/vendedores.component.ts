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
  vendedores: Vendedor[];

  constructor(private vendedoresService: VendedoresService) {
  }

  ngOnInit() {
    this.vendedoresService.buscar('').subscribe(vendedores => {
      this.vendedores = vendedores;
      this.vendedoresService.atualizarStatusBusca(false);
    });
  }

  filtrarVendedores(filtro: string) {
    this.vendedoresService.buscar(filtro).subscribe(vendedores => {
      this.vendedores = vendedores;
      this.vendedoresService.atualizarStatusBusca(false);
    });
  }

  limparFiltros() {
    this.vendedoresService.buscar('').subscribe(vendedores => {
      this.vendedores = vendedores;
      this.vendedoresService.atualizarStatusBusca(false);
    });
    this.filtro.nativeElement.value = '';
    this.filtro.nativeElement.focus();
  }

  ngAfterViewInit(): void {
    this.filtro.nativeElement.focus();
  }

  isBuscandoVendedores(): boolean {
    return this.vendedoresService.isBuscando();
  }

}
