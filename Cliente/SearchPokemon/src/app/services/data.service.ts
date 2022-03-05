import { Injectable } from '@angular/core';
import { data } from 'jquery';
import { Pokemon } from "../entity/pokemon";
import { Type } from "../entity/type";

declare var $: any;

@Injectable({
  providedIn: 'root'
})

export class DataService {

  public pokemon: Pokemon = { nombre: "", urlFront: "" };
  public pokemons: Array<Pokemon> = [];
  public types: Array<Type> = [];
  public boolean: boolean = true;

  constructor() { }

  //Con este metodo obtenemos 30 pokemons, empezando desde el numero que se le indica
  public getPokemons(numero: string | number) {
    this.pokemons = [];
    this.boolean = true;
    var loading: any = $("#loading");

    fetch("https://pokeapi.co/api/v2/pokemon?limit=30&offset=" + numero, {
      method: "GET",
      mode: "cors"
    })
      .then(resp => resp.json())
      .then( data => {
        data.results.forEach((element: any) => {
          this.pokemons.push( this.search(element.url));
        });

        loading.hide();
      })
      .catch(error => console.log(error));

    return this.pokemons;
  }

  //Se busca al pokemon por la url y devuelve un pokemon
  public search(url: string) {
    var pokemon: Pokemon = { nombre: "", urlFront: "" };

    fetch(url, {
      method: "GET",
      mode: "cors"
    })
      .then(resp => resp.json())
      .then(data => {
        pokemon.nombre = this.firtsUpperCase(data.name);
        pokemon.urlFront = data.sprites.front_default;
        pokemon.numberType = data.types[0].type.name;
      })
      .catch(error => console.log(error));

    return pokemon;
  }

  //TIPO
  //Cogemos los tipos de la API y guardamos el nombre con su url.
  public getType(): any {

    fetch("https://pokeapi.co/api/v2/type", {
      method: "GET",
      mode: "cors"
    })
      .then(resp => resp.json())
      .then(data => {
        data.results.forEach((element: any) => {
          var type = { nombre: element.name, url: element.url }
          this.types.push(type);
        });
      })
      .catch(error => console.log(error));

    return this.types;
  }
  //Pasamos la url de getType y añadimos los pokemos de esa url.
  searchType(url: string) {
    this.pokemons = [];
    this.boolean = false;

    fetch(url, {
      method: "GET",
      mode: "cors"
    })
      .then(resp => resp.json())
      .then(data => {
        data.pokemon.forEach((element: any) => {
          this.pokemons.push(this.search(element.pokemon.url));
        });
      })
      .catch(error => {this.pokemons = []});

    return this.pokemons;
  }

  //Buscamos en la API el nombre del pokemon que le pasamos
  //Y le añadimos sus variables
  moreDetails(name: string) {
    var url = "https://pokeapi.co/api/v2/pokemon/" + name.toLowerCase();
    this.pokemons = [];
    this.boolean = false;

    fetch(url, {
      method: "GET",
      mode: "cors"
    })
      .then(resp => resp.json())
      .then(data => {
        this.pokemons.push(
          this.pokemon = {
            nombre: this.firtsUpperCase(data.name),
            urlFront: data.sprites.front_default,
            urlBack: data.sprites.back_default,
            type: "Type: " + data.types[0].type.name,
            hp: this.firtsUpperCase(data.stats[0].stat.name) + ": " + data.stats[0].base_stat,
            attack: this.firtsUpperCase(data.stats[1].stat.name) + ": " + data.stats[1].base_stat,
            defense: this.firtsUpperCase(data.stats[2].stat.name) + ": " + data.stats[2].base_stat,
            speed: this.firtsUpperCase(data.stats[5].stat.name) + ": " + data.stats[5].base_stat,
          });
      })
      .catch(error => console.log(error));

    return this.pokemons;
  }

  endScroll() {

    //El if es para que solo se ejecute cuando se lo permito
    if(this.boolean == true){
      //Cogemos el tamaño de nuestro array de objetos pokemon
      var size = this.pokemons.length + 1;
      //Almacenamos los pokemons que ya han sido creados
      var oldPokemons = this.pokemons;
      //Y adquirimos pokemons desde el tamaño del array
      var newPokemons = this.getPokemons(size);
      //Por ultimo concatenamos en nuestro array de objetos Pokemon
      //los pokemon ya almacenados y los nuevos para listarlos
      this.pokemons = oldPokemons.concat(newPokemons);
    }
  }

  //Aqui convertimos la primera letra del string en mayuscula
  firtsUpperCase(word: string): string {
    word = word.charAt(0).toUpperCase() + word.slice(1);
    return word;
  }

}
