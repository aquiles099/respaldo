<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Admin\Contract;
use Carbon\Carbon;
use App\Helpers\HStatus;
use DB;

class ContractCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contract:verify';
    /**
    *
    */
    protected $description = 'Verifica las fechas de vencimiento de cada contrato';
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
      $contracts = Contract::all();
      $now  = Carbon::now();
      \Log::info('Iniciando revision de contratos >>>');
      /**
      *
      */
      if ($contracts->count() == 0) {
          \Log::info('sin contratos');
      } else {
        /**
        *
        */
        foreach ($contracts as $key => $value) {
          $parse_date = Carbon::parse($value->cut_off_date);
          \Log::info('revisando contrato: '.$value->code);
          $left_date = $now->diffInDays($parse_date);
          /**
          *
          */
          if ($vaue->status != HStatus::DEFEATED) {
            \Log::notice('Dias restantes: '.$now->diffInDays($parse_date));
          } else {
            \Log::notice('Dias vencidos: '.$now->diffInDays($parse_date));
          }
          /**
          * 1) Se ejecuta el cambio de status
          * 2) Por vencer
          * 3) Vencido
          */
          if ($left_date > 0 && $left_date <= 15) {
            if ($value->status != HStatus::DEFEATED) {
                $this->warning($value->id);
            }
          } else {
            if ($left_date <= 0) {
              $this->defeated($value->id);
            }
          }
        }
      }
      \Log::info('Proceso de revision de contratos terminado <<<');
      \Log::info('______________________________________________');
    }
    /**
    * 1) Recibe el id de un contrato
    * 2) Modifica el status de un contrato a 'Por vencer'
    */
    public function warning ($id) {
      DB::table('contract')->where('id', '=', $id)->update(['status' => HStatus::WARNING]);
     \Log::notice('Se ha modificado el status del contrato '.$id.' a POR VENCER');
    }
    /**
    * 1) Recibe el id de un contrato
    * 2) Modifica el status de un contrato a 'VENCIDO'
    */
    public function defeated ($id) {
      DB::table('contract')->where('id', '=', $id)->update(['status' => HStatus::DEFEATED]);
      \Log::notice('Modificado el status del contrato '.$id.' a VENCIDO');
    }
}
