<?php

namespace App\Console\Commands;

use App\Interfaces\ElevadorInterface;
use Illuminate\Console\Command;

class ElevadorSimulacao extends Command
{
    protected $signature = 'elevador:simular';
    protected $description = 'Simula o funcionamento de um elevador';
    
    private ElevadorInterface $elevador;

    public function handle(ElevadorInterface $elevador)
    {
        $this->elevador = $elevador;
        $this->iniciarSimulacao();
        
        $continuar = true;
        while ($continuar) {
            $opcao = $this->exibirMenuOpcoes();
            $continuar = $this->processarOpcao($opcao);
        }

        return 0;
    }
    
    private function iniciarSimulacao(): void
    {
        $this->info('Simulação de Elevador iniciada!');
        $this->exibirAndarAtual();
    }

    private function exibirMenuOpcoes(): string
    {
        return $this->choice('O que deseja fazer?', [
            'chamar' => 'Chamar o elevador para um andar',
            'mover' => 'Mover o elevador para o próximo chamado',
            'status' => 'Ver status atual',
            'sair' => 'Sair da simulação'
        ]);
    }
    
    private function processarOpcao(string $opcao): bool
    {
        switch ($opcao) {
            case 'chamar':
                $this->chamarElevador();
                break;
            case 'mover':
                $this->moverElevador();
                break;
            case 'status':
                $this->exibirStatus();
                break;
            case 'sair':
                $this->info('Simulação encerrada!');
                return false;
        }
        
        return true;
    }
    
    private function chamarElevador(): void
    {
        $andar = (int) $this->ask('Para qual andar deseja chamar o elevador?');
        
        try {
            $this->elevador->chamar($andar);
            $this->info("Elevador chamado para o andar {$andar}.");
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
    
    private function moverElevador(): void
    {
        $this->elevador->mover();
    }
    
    private function exibirStatus(): void
    {
        $this->exibirAndarAtual();
        $this->exibirChamadosPendentes();
    }
    
    private function exibirAndarAtual(): void
    {
        $this->info("Andar atual: {$this->elevador->getAndarAtual()}");
    }
    
    private function exibirChamadosPendentes(): void
    {
        $chamados = $this->elevador->getChamadosPendentes();
        $chamados->rewind();
        
        if ($chamados->isEmpty()) {
            $this->info("Não há chamados pendentes.");
            return;
        }
        
        $this->info("Chamados pendentes:");
        while ($chamados->valid()) {
            $this->info(" - Andar {$chamados->current()}");
            $chamados->next();
        }
    }
}