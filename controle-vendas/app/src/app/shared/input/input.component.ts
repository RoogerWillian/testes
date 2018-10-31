import {Component, Input, OnInit, ContentChild, AfterContentInit} from '@angular/core';
import {Form, FormControlName, NgModel} from '@angular/forms';

@Component({
  selector: 'gv-input-container',
  templateUrl: './input.component.html'
})
export class InputComponent implements OnInit, AfterContentInit {

  @Input() label: string;
  @Input() errorMessage: string;
  input: any;

  @ContentChild(NgModel) model: NgModel;
  @ContentChild(FormControlName) control: FormControlName;

  constructor() {
  }

  ngOnInit() {
  }

  ngAfterContentInit(): void {
    this.input = this.model || this.control;
    if (this.input === undefined) {
      throw new Error('Esse componete precisa ser usado com uma directiva ngModel ou formControlName')
    }
  }

  hasSuccess(): boolean {
    return this.input.valid && (this.input.dirty || this.input.touched)
  }

  hasError(): boolean {
    return this.input.invalid && (this.input.dirty || this.input.touched)
  }
}
