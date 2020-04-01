<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {
    /**
    *
    */
    protected $commands = [
      Commands\TestCommand::class,
      Commands\SessionCommand::class,
      Commands\ContractCommand::class,
      Commands\BillingCommand::class
    ];
    /**
    *
    */
    protected function schedule(Schedule $schedule) {
      /*1*/$schedule->command('test:review')->daily();
      /*2*/$schedule->command('contract:verify')->daily();
      /*3*/$schedule->command('billing:verify')->daily();
    }
}
