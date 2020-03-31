<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailsPickupOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        /**
        * Tabla para la sequencia
        */
        Schema::create('seq_details_pickup_order', function (Blueprint $table)
        {
          $table->bigInteger('id');
        });
        /**
        * Estructura de la tabla
        */

        Schema::create('details_pickup_order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description', 200)->nullable();
            $table->bigInteger('type')->nullable();
            $table->bigInteger('partnumber')->nullable();
            $table->float('large')->nullable();
            $table->float('width')->nullable();
            $table->float('height')->nullable();
            $table->float('weight')->nullable();
            $table->float('volumetricweight')->nullable();
            $table->bigInteger('pieces')->nullable();
            $table->float('value')->nullable();
            $table->string('tracking', 100)->nullable();
            $table->string('invoice', 100)->nullable();
            $table->string('po', 100)->nullable();
            $table->bigInteger('pickup')->nullable();
            $table->string('start_at',100)->nullable();
            $table->timestamps();
            $table->softDeletes();
      });




        /**
         * Funcion de Validacion
         */
        DB::connection()->getPdo()->exec('
            drop function if exists seq_details_pickup_order_func;
            create function seq_details_pickup_order_func() returns bigint
              begin
                if(not(exists(select id from seq_details_pickup_order))) then
                  insert into seq_details_pickup_order values (0);
                end if;
                update seq_details_pickup_order set id = last_insert_id(id + 1);
                while exists(select null from details_pickup_order where id = last_insert_id()) do
                  update seq_details_pickup_order set id = last_insert_id(id + 1);
                end while;
                return last_insert_id();
              end
          ');
          /**
          * Creacion del trigger
          */
          DB::connection()->getPdo()->exec('
            drop trigger if exists seq_details_pickup_order_trigger;
              create trigger seq_details_pickup_order_trigger before insert on details_pickup_order
                for each row
                  begin
                    if new.id is null or new.id = -1 then
                      set new.id = seq_details_pickup_order_func();
                    end if;
                  end
          ');


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
    {
      DB::connection()->getPdo()->exec('drop trigger if exists seq_details_pickup_order_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_details_pickup_order_func');
      Schema::drop('details_pickup_order');
      Schema::drop('seq_details_pickup_order');
    }
}
