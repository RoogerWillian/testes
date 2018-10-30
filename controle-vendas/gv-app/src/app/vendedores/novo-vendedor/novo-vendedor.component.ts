import {Component, ElementRef, OnInit, ViewChild} from '@angular/core';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {Router} from '@angular/router';
import {Vendedor} from '../vendedor.model';
import {VendedoresService} from '../vendedores.service';

@Component({
  selector: 'gv-novo-vendedor',
  templateUrl: './novo-vendedor.component.html'
})
export class NovoVendedorComponent implements OnInit {

  vendedorForm: FormGroup;
  emailPattern = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
  @ViewChild('botaoSalvar', {read: ElementRef}) botaoSalvar: ElementRef;

  constructor(private router: Router, private formBuilder: FormBuilder,
              private vendedorService: VendedoresService) {
  }

  ngOnInit() {
    this.vendedorForm = this.formBuilder.group({
      nome: this.formBuilder.control('', [Validators.required]),
      email: this.formBuilder.control('', [Validators.required, Validators.pattern(this.emailPattern)])
    });
  }

  salvarVendedor(vendedor: Vendedor) {
    this.vendedorService.salvar(vendedor).subscribe(() => {
      this.router.navigate(['/vendedores']);
    });
  }
}
