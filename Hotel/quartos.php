<?php
require_once "Hotel.php";

$hotel = new Hotel();
$quartos = $hotel->listarQuartos();

$dados = [];
foreach ($quartos as $quarto) {
    $dados[] = [
        "numero" => $quarto->getNumero(),
        "tipo" => ($quarto instanceof QuartoLuxo) ? "Luxo" : "Simples",
        "preco" => $quarto->getPreco(),
        "status" => $quarto->isOcupado() ? "Ocupado" : "Disponível"
    ];
}

console.log($dados);
header('Content-Type: application/json');
echo json_encode($dados);
?>
