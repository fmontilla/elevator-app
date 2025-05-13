<?php

namespace App\Models;

use App\Interfaces\ElevadorInterface;
use App\Interfaces\FilaInterface;
use App\Exceptions\AndarInvalidoException;
use SplQueue;

class Elevador implements ElevadorInterface
{
    private FilaInterface $filaChamados;
    private int $andarAtual;
    private int $capacidade;

    public function __construct(FilaInterface $filaChamados, int $capacidade)
    {
        $this->filaChamados = $filaChamados;
        $this->andarAtual = 0; // Inicializa no térreo
        $this->capacidade = $capacidade;
    }

    public function chamar(int $andar): void
    {
        if ($andar < 0) {
            throw new AndarInvalidoException("O andar não pode ser negativo");
        }

        $this->filaChamados->adicionar($andar);
    }

    public function mover(): void
    {
        if ($this->filaChamados->estaVazia()) {
            echo "Não há chamados pendentes.\n";
            return;
        }

        $proximoAndar = $this->filaChamados->remover();
        
        if ($this->andarAtual < $proximoAndar) {
            echo "Subindo para o andar {$proximoAndar}...\n";
        } elseif ($this->andarAtual > $proximoAndar) {
            echo "Descendo para o andar {$proximoAndar}...\n";
        } else {
            echo "Já estamos no andar {$proximoAndar}.\n";
        }

        $this->andarAtual = $proximoAndar;
        echo "Chegamos ao andar {$this->andarAtual}.\n";
    }

    public function getAndarAtual(): int
    {
        return $this->andarAtual;
    }

    public function getChamadosPendentes(): SplQueue
    {
        return $this->filaChamados->obterFila();
    }
}