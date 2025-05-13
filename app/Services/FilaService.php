<?php

namespace App\Services;

use App\Interfaces\FilaInterface;
use SplQueue;

class FilaService implements FilaInterface
{
    private SplQueue $fila;

    public function __construct()
    {
        $this->fila = new SplQueue();
    }

    public function adicionar(int $item): void
    {
        $this->fila->enqueue($item);
    }

    public function remover()
    {
        if ($this->estaVazia()) {
            return null;
        }
        
        return $this->fila->dequeue();
    }

    public function estaVazia(): bool
    {
        return $this->fila->isEmpty();
    }

    public function obterFila()
    {
        return clone $this->fila;
    }
}