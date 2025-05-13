<?php

namespace App\Interfaces;

use SplQueue;

interface ElevadorInterface
{
    public function chamar(int $andar): void;
    public function mover(): void;
    public function getAndarAtual(): int;
    public function getChamadosPendentes(): SplQueue;
}