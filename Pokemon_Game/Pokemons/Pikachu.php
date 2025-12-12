<?php
namespace Pokemons;
class Pikachu extends Pokemon {
    public function __construct() {
        parent::__construct("Pikachu", "eletrico", 
        ["Raio", "Choque do Trovão"],
        ["Terrestre"],
        ["Eletrico"], 
         42,
         55,
         40,
         43,
         50);
    }
}
