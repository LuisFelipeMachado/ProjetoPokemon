<?php

abstract class Quarto {
    protected $numero;
    protected $preco;
    private $ocupado = false;

    public function __construct($numero, $preco) {
        $this->numero = $numero;
        $this->preco = $preco;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function getPreco() {
        return $this->preco;
    }

    public function isOcupado() {
        return $this->ocupado;
    }

    public function reservar() {
        $this->ocupado = true;
    }

    abstract public function calcularPreco($dias);
}

class QuartoSimples extends Quarto {
    public function calcularPreco($dias) {
        return $this->preco * $dias;
    }
}

class QuartoLuxo extends Quarto {
    private $taxaLuxo = 1.5;

    public function calcularPreco($dias) {
        return ($this->preco * $dias) * $this->taxaLuxo;
    }
}

class Hotel {
    private $quartos = [];
    private $reservas = [];

    public function __construct() {
        $this->carregarReservas();
        $this->carregarQuartos();
    }

    private function carregarQuartos() {
        $this->quartos = [
            new QuartoSimples(101, 100),
            new QuartoLuxo(202, 250),
            new QuartoSimples(303, 100),
            new QuartoLuxo(404, 250)
        ];
    }

    public function listarQuartos() {
        return $this->quartos;
    }

    public function listarReservas() {
        return $this->reservas;
    }

    public function reservarQuarto($numero, $hospede, $dias) {
        foreach ($this->quartos as $quarto) {
            if ($quarto->getNumero() == $numero && !$quarto->isOcupado()) {
                $quarto->reservar();
                $precoTotal = $quarto->calcularPreco($dias);

                $this->reservas[] = [
                    "quarto" => $numero,
                    "hospede" => $hospede,
                    "dias" => $dias,
                    "total" => $precoTotal
                ];

                $this->salvarReservas();
                return "Reserva feita para $hospede no Quarto $numero por $dias dias.";
            }
        }
        return "Erro: Quarto $numero já está ocupado!";
    }

    private function carregarReservas() {
        if (file_exists("dados.json")) {
            $this->reservas = json_decode(file_get_contents("dados.json"), true) ?: [];
        }
    }

    private function salvarReservas() {
        file_put_contents("dados.json", json_encode($this->reservas, JSON_PRETTY_PRINT));
        console_log("Reservas salvas com sucesso.");
    }
}
?>
