import { Component, OnInit } from '@angular/core';
import { DataService } from '../services/data.service';
import { Pokemon } from "../entity/pokemon";
declare var $: any;

@Component({
  selector: 'app-pokemon',
  templateUrl: './pokemon.component.html',
  styleUrls: ['./pokemon.component.css']
})

export class PokemonComponent implements OnInit {

  constructor(public dataService: DataService) { }

  ngOnInit(): void {
    //Aqui listamos nuestros primeros pokemons
    this.dataService.getPokemons(0);
  }

  //Detecta cuando estamos abajo de la pagina
  onScrollDown(ev: any) {
    this.dataService.endScroll();
  }

  selectColor(type: string | any): any {

    var types = this.dataService.types;

    switch (type) {

      case types[0].nombre:
        return "#fff";
      case types[1].nombre:
        return "#E8E0D5";
      case types[2].nombre:
        return "#DBFF8";
      case types[3].nombre:
        return "#D0DDFF";
      case types[4].nombre:
        return "#D0C195";
      case types[5].nombre:
        return "#CFDBDB";
      case types[6].nombre:
        return "#E1FFAC";
      case types[7].nombre:
        return "#C5A2C5";
      case types[8].nombre:
        return "#7D868E";
      case types[9].nombre:
        return "#FF6961";
      case types[10].nombre:
        return "#50A7FF";
      case types[11].nombre:
        return "#9DCD8C";
      case types[12].nombre:
        return "#F5FFA2";
      case types[13].nombre:
        return "#fff";
      case types[14].nombre:
        return "#fff";
      case types[15].nombre:
        return "#fff";
      case types[16].nombre:
        return "#fff";
      case types[17].nombre:
        return "#fff";
      case types[18].nombre:
        return "#fff";
    }
  }

}

