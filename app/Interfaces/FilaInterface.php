<?php

namespace App\Interfaces;

interface FilaInterface
{
    public function adicionar(int $item): void;
    public function remover();
    public function estaVazia(): bool;
    public function obterFila();
}