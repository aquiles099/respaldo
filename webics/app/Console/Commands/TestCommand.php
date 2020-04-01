<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Admin\Test;
use Carbon\Carbon;
use App\Helpers\HStatus;
use DB;

class TestCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:review';
    /**
    *
    */
    protected $description = 'Verifica las fechas de vencimiento de cada prueba';
    /**
    *
    */
    public function __construct() {
        parent::__construct();
    }
    /**
    *
    */
    public function handle () {
      $tests = Test::all();
      $now  = Carbon::now();
      \Log::info('Iniciando revision de pruebas >>>');
      /**
      * Verifica el total de pruebas, si existe por lo menos una salta esta condicion
      */
      if ($tests->count() == 0) {
        \Log::info('sin pruebas');
      } else {
        /**
        * 1) Start [FOREACH]
        * 2) Se verifican las pruebas encntradas
        * 3) Se modfica el status segun sea el caso
        */
        foreach ($tests as $key => $value) {
          /**
          * Se procesa la fecha de corte
          */
          $parse_date = Carbon::parse($value->cutoff_date);
          \Log::info('revisando prueba: '.$value->code);
          $left_date = $now->diffInDays($parse_date);
          /**
          * Se escribe en el log tomando en cuenta el status de la prueba
          * 1)
          */
          if ($value->status != HStatus::DEFEATED) {
            \Log::notice('Dias restantes: '.$now->diffInDays($parse_date));
          } else {
            \Log::notice('Dias vencidos: '.$now->diffInDays($parse_date));
          }
          /**
          * 1) Se ejecuta el cambio de status
          * 2) Por vencer
          * 3) Vencido
          */
          if ($left_date > 0 && $left_date <= 5) {
            if ($value->status != HStatus::DEFEATED) {
                $this->warning($value->id);
            }
          } else {
            if ($left_date <= 0) {
              $this->defeated($value->id);
            }
          }
        }
        /**
        * End [FOREACH]
        */
      }
      \Log::info('Proceso de revision de pruebas terminado <<<');
      \Log::info('______________________________________________');
    }
    /**
    * 1) Recibe el id de una prueba
    * 2) Modifica el status de una prueba a 'Por vencer'
    */
    public function warning ($id) {
      DB::table('test')->where('id', '=', $id)->update(['status' => HStatus::WARNING]);
     \Log::notice('Se ha modificado el status de la prueba '.$id.' a POR VENCER');
    }
    /**
    * 1) Recibe el id de una prueba
    * 2) Modifica el status de una prueba a 'VENCIDO'
    */
    public function defeated ($id) {
      DB::table('test')->where('id', '=', $id)->update(['status' => HStatus::DEFEATED]);
      \Log::notice('Modificado el status de la prueba '.$id.' a VENCIDO');
    }
}
