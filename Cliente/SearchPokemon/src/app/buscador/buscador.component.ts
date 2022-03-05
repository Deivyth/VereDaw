import { Component, OnInit  } from '@angular/core';
import { DataService } from '../services/data.service';
import { Type } from '../entity/type';

@Component({
  selector: 'app-buscador',
  templateUrl: './buscador.component.html',
  styleUrls: ['./buscador.component.css']
})
export class BuscadorComponent implements OnInit {

  public types: Array<Type> = [];
 
  constructor(public dataService: DataService) {}

  ngOnInit(): void {
    this.types = this.dataService.getType();
  }

}
