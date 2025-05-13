<?php

namespace App\Providers;

use App\Interfaces\FilaInterface;
use App\Interfaces\ElevadorInterface;
use App\Services\FilaService;
use App\Models\Elevador;
use Illuminate\Support\ServiceProvider;

class ElevadorServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(FilaInterface::class, FilaService::class);
        
        $this->app->bind(ElevadorInterface::class, function ($app) {
            $filaService = $app->make(FilaInterface::class);
            return new Elevador($filaService, 10); // Capacidade de 10 pessoas
        });
    }
}