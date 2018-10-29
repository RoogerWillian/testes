import {BrowserModule} from '@angular/platform-browser';
import {NgModule} from '@angular/core';
import {RouterModule} from '@angular/router';
import {AppComponent} from './app.component';
import {HeaderComponent} from './header/header.component';
import {HomeComponent} from './home/home.component';
import {ROUTES} from './app.routes';
import {HttpClientModule} from '@angular/common/http';
import {VendasComponent} from './vendas/vendas.component';
import {VendedoresComponent} from './vendedores/vendedores.component';
import {VendedoresService} from './vendedores/vendedores.service';
import {VendasService} from './vendas/vendas.service';

@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    HomeComponent,
    VendasComponent,
    VendedoresComponent
  ],
  imports: [
    BrowserModule,
    HttpClientModule,
    RouterModule.forRoot(ROUTES)
  ],
  providers: [VendedoresService, VendasService],
  bootstrap: [AppComponent]
})
export class AppModule {
}
