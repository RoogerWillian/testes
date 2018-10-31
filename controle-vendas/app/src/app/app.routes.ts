import {Routes} from '@angular/router';
import {HomeComponent} from './home/home.component';
import {VendedoresComponent} from './vendedores/vendedores.component';
import {VendasComponent} from './vendas/vendas.component';
import {NovoVendedorComponent} from './vendedores/novo-vendedor/novo-vendedor.component';
import {NovaVendaComponent} from './vendas/nova-venda/nova-venda.component';

export const ROUTES: Routes = [
  {path: '', component: HomeComponent},
  {path: 'vendedores', component: VendedoresComponent},
  {path: 'vendedores/novo', component: NovoVendedorComponent},
  {path: 'vendas', component: VendasComponent},
  {path: 'vendas/lancar', component: NovaVendaComponent}
];
