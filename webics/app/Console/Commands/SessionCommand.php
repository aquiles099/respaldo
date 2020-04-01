<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SessionCommand extends Command {

    /**
    *
    */
    protected $signature = 'session:verify';
    /**
    *
    */
    protected $description = 'Verifica el status de la sesion y cierra el sistema si es nula';
    /**
    *
    */
    public function __construct() {
        parent::__construct();
    }
    /**
    *
    */
    public function handle() {
      \Log::info('probando session: ');
    }
}
