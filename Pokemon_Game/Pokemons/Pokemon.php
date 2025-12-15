<?php
namespace Pokemons;

abstract class Pokemon {
    protected string $name;
    protected string $tipo;
    protected array $movimentos;
    protected array $fraquezas;
    protected array $resistencias;
    protected float $hp;
    protected float $health;
    protected float $ataque;
    protected float $defesa;
    protected float $ataqueEspecial;

    protected function __construct(string $name, string $tipo, array $movimentos, array $fraquezas, array $resistencias, float $hp, float $baseAtaque, float $baseDefesa, float $baseAtaqueEspecial) {
        $this->name = $name;
        $this->tipo = $tipo;
        $this->movimentos = $movimentos;
        $this->fraquezas = $fraquezas;
        $this->resistencias = $resistencias;
        $this->hp = $hp;
        $this->health = $this->calcularHealth($hp);
        $this->ataque = $this->calcularEstatistica($baseAtaque);
        $this->defesa = $this->calcularEstatistica($baseDefesa);
        $this->ataqueEspecial = $this->calcularEstatistica($baseAtaqueEspecial);
    }
    public function getName(): string {
        return $this->name;
    }

    public function getTipo(): string {
        return $this->tipo;
    }

    public function getMovimentos(): array {
        return $this->movimentos;
    }

    public function getFraquezas(): array {
        return $this->fraquezas;
    }

    public function getResistencias(): array {
        return $this->resistencias;
    }

    public function getHealth(): float {
        return $this->health;
    }

    public function getAtaque(){
        return $this->ataque;
    }
    public function getDefesa(){
        return $this->defesa;
    }
    public function getAtaqueEspecial(){
        return $this->ataqueEspecial;
    }

    public function reduzirVida(float $dano): void {
        $this->health -= $dano;
        if ($this->health < 0) {
            $this->health = 0;
        }
    }

    protected function calcularHealth(float $baseHP): float {
        return (((31 * 2) / 4 + $baseHP + 100) / 100) * 50 + 10 + 50;
    }

    protected function calcularEstatistica(float $stat): float {
        return ((2 * $stat + 31) * 50 / 100) + 5;
    }

    public function aplicarPassiva(): void {
        $recuperacao = $this->health * 0.10;
        $this->health += $recuperacao;
    }
}

