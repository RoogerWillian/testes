import {Routes} from '@angular/router';
import {HomeComponent} from './home/home.component';
import {VendedoresComponent} from './vendedores/vendedores.component';
import {VendasComponent} from './vendas/vendas.component';

export const ROUTES: Routes = [
  {path: '', component: HomeComponent},
  {path: 'vendedores', component: VendedoresComponent},
  {path: 'vendas', component: VendasComponent}
];
