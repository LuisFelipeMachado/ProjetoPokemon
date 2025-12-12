<?php 
require_once __DIR__ . '/vendor/autoload.php';

use Pokemons\Charmander;
use Pokemons\Squirtle;
use Pokemons\Pikachu;
use Movimentos\AtaqueFisico;
use Movimentos\AtaqueEspecial;

echo "Selecione o seu Pokémon:\n";
$opcoes = [
    1 => new Charmander(),
    2=> new Squirtle(),
    3=> new Pikachu(),
];

foreach ($opcoes as $numero => $pokemon){
    echo "$numero -" . $pokemon->getName() . "\n";
}
$entrada = readline("Digite um Número do seu Pokémon\n");
$jogador = $opcoes[$entrada] ?? new Charmander();

echo "\nVocê Escolheu: " . $jogador->getName() . "\n";
echo "Tipo: " . $jogador->getTipo() . "\n";
echo "HP: " . $jogador->getHealth() . "\n";
echo "Ataque: " . $jogador->getAtaque() . "\n";
echo "Defesa " . $jogador->getDefesa() . "\n";
echo "AtaqueEspecial: " . $jogador->getAtaqueEspecial() . "\n";

readline("\nPressione ENTER para iniciar a Batalha");

$todos = [new Charmander(), new Squirtle(), new Pikachu()];
$adversarios = array_filter($todos, function($pokemon) use ($jogador) {
    return $pokemon->getName() !== $jogador->getName();
});

$adversarios = array_values($adversarios);
$adversario= $adversarios[array_rand($adversarios)];
echo "\nSeu adversário será" . $adversario->getName() . "\n";

function criarMovimentos($pokemon){
    $tipo = strtolower($pokemon->getTipo());
    $movimentos = [];
    if ($tipo === "fogo") {
        $movimentos [] = new AtaqueFisico("Investida Flamejante", 30, "Fisico", "fogo");
        $movimentos [] = new AtaqueEspecial("Lança-Chamas", 40, "Especial", "fogo");
    }
    elseif ($tipo === "agua" || $tipo === "Água") {
        $movimentos [] = new AtaqueFisico("Investida Áquatica", 30, "Físico", "Água");
        $movimentos [] = new AtaqueEspecial("Jato de Água", 40, "Especial", "Água");
    }
    elseif ($tipo === "eletrico" || $tipo === "Eletrico"){
        $movimentos [] = new AtaqueFisico("Investida Eletrica", 30, "Fisico", "Elétrico");
        $movimentos [] = new AtaqueEspecial("Choque do Trovão", 40, "Especial", "Elétrico");
    }
    return $movimentos;
}
 $movimentosJogador = criarMovimentos($jogador);
 $movimentosAdversario = criarMovimentos($adversario);

 $turno = 1;

 while($jogador->getHealth() > 0 && $adversario->getHealth() > 0) {
    echo "\n---- Turno $turno ----\n";

    if(method_exists($jogador,'aplicarPassiva')){
        $jogador->aplicarPassiva($adversario);
    }
    $movimentoJ = $movimentosJogador[array_rand($movimentosJogador)];
    $movimentoJ->usarMovimento($jogador, $adversario);
    if ($adversario->getHealth() <=0){
        echo $adversario->getName() . "Foi Derrotado!";
        break;
    }
    if(method_exists($adversario, 'aplicarPassiva')){
    $adversario->aplicarPassiva($jogador);
    }

    $movimentoA = $movimentosAdversario[array_rand($movimentosAdversario)];
    $movimentoA->usarMovimento($adversario, $jogador);
      if ($jogador->getHealth() <= 0){
        echo $jogador->getName() . 'Foi derrotado" \n';
        break;
      }

      echo "HP de " . $jogador->getName() . ":" . $jogador->getHealth() ."\n";
      echo "HP de " . $adversario->getName() . ":". $adversario->getHealth() ."\n";

      $turno++;
    }

    echo "\nBatalha Finalizada\n";
