<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Admin\Contract;
use App\Models\Admin\Billing;
use App\Models\Admin\Solicitude;
use App\Models\Admin\Client;
use App\Helpers\HStatus;
use Carbon\Carbon;
use DB;
use \Mail;

class BillingCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'billing:verify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica las proximas fechas de pago';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct () {
        parent::__construct();
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle () {
      $billings =  Billing::all();
      $now  = Carbon::now();
      \Log::info('Iniciando revision de recibos y contratos >>>');
      /**
      *
      */
      if (isZero($billings->count())) {
        \Log::info('sin recibos');
      } else {
        /**
        * 1) se formatea la fecha a formato CARBON
        * 2) se compara la fecha de corte del recibo con la fecha actual
        */
        foreach ($billings as $key => $value) {

          $parse_date = Carbon::parse($value->next_pay);
          \Log::info('revisando recibo: '.$value->code);
          $left_date = $now->diffInDays($parse_date);
          \Log::info('dias restantes: '.$left_date);
          /**
          *
          */
          $solicitude = Solicitude::find($value->solicitude);
          if (is_null($solicitude)) {
            \Log::info('no se encontro la solicitud asociada al recibo '.$value->code);
          } else {
            \Log::info('solicitud asociada: '.$solicitude->code);
          }
          /**
          *
          */
          $contract = Contract::bySolicitude($solicitude->id)->first();
          if (is_null($contract)) {
             \Log::info('no se encontro el contrato asociado al recibo: '.$value->code);
          } else {
            \Log::info('contrato asociado: '.$contract->code);
          }
          /**
          *
          */
          \Log::info('fecha de proximo pago: '.$value->next_pay);
          \Log::info('dias restantes: '.$left_date);
          /**
          *
          */
          $client = Client::find($solicitude->client);
          if (is_null($client)) {
              \Log::info('no se encontro el cliente asociado al contrato '.$contract->code);
          }
          /**
          * 1) se verifica la deuda del recibo asociado a un contrato
          * 2) se ejecuta un cambio de estatus si la deuda es mayor a cero [ debt > 0]
          */
          if (!isZero($value->debt)) {
            \Log::info('deuda actual: '.$value->debt);
            if ($left_date > 0 && $left_date < 5) {
              if ($value->status != HStatus::DEFEATED) {
                $this->warning($value->id);
              }
            } else {
                if ($left_date <= 0) {
                  $this->inactive($value->id);
                }
            }
          } else {
            \Log::info($value->debt.' sin deuda');
          }
          /**
          *
          */
          \Log::info('.........................................');
        }
      }
      /**
      *
      */
      \Log::info('Revision de recibos y contrato terminada <<<');
      \Log::info('____________________________________________');
    }
    /**
    * 1) Recibe el id de un contrato
    * 2) Modifica el status de un contrato a 'POR VENCER'
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
    /**
    * 1) Recibe el id de un contrato
    * 2) Modifica el status de un contrato a 'INACTIVO'
    */
    public function inactive ($id) {
      DB::table('contract')->where('id', '=', $id)->update(['status' => HStatus::INACTIVE]);
      \Log::notice('Modificado el status del contrato '.$id.' a INACTIVO');
    }
}
