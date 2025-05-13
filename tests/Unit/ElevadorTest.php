<?php

namespace Tests\Unit;

use App\Interfaces\FilaInterface;
use App\Models\Elevador;
use App\Services\FilaService;
use PHPUnit\Framework\TestCase;

class ElevadorTest extends TestCase
{
    private FilaInterface $filaService;
    private Elevador $elevador;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->filaService = new FilaService();
        $this->elevador = new Elevador($this->filaService, 10);
    }

    public function testInicializacaoDoElevador()
    {
        $this->assertEquals(0, $this->elevador->getAndarAtual());
        $this->assertTrue($this->elevador->getChamadosPendentes()->isEmpty());
    }

    public function testChamadaDeElevador()
    {
        $this->elevador->chamar(5);
        $this->assertFalse($this->elevador->getChamadosPendentes()->isEmpty());
        
        $chamados = $this->elevador->getChamadosPendentes();
        $chamados->rewind();
        $this->assertEquals(5, $chamados->current());
    }

    public function testMovimentacaoDoElevador()
    {
        $this->elevador->chamar(3);
        $this->elevador->mover();
        $this->assertEquals(3, $this->elevador->getAndarAtual());
        $this->assertTrue($this->elevador->getChamadosPendentes()->isEmpty());
    }

    public function testMultiplasChamadas()
    {
        $this->elevador->chamar(2);
        $this->elevador->chamar(5);
        $this->elevador->chamar(1);
        
        $this->elevador->mover();
        $this->assertEquals(2, $this->elevador->getAndarAtual());
        
        $this->elevador->mover();
        $this->assertEquals(5, $this->elevador->getAndarAtual());
        
        $this->elevador->mover();
        $this->assertEquals(1, $this->elevador->getAndarAtual());
        
        $this->assertTrue($this->elevador->getChamadosPendentes()->isEmpty());
    }

    public function testElevadorSemChamados()
    {
        $this->expectOutputString("Não há chamados pendentes.\n");
        $this->elevador->mover();
    }
}