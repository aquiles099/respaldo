<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePickupOrdersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up () {

     /**
        * Tabla para la sequencia
        */
        Schema::create('seq_pickup_orders', function (Blueprint $table) {
          $table->bigInteger('id');
        });
        /**
        * Estructura de la tabla
        */
        Schema::create('pickup_orders', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('code');
          $table->bigInteger('from_user')->unsigned()->nullable();
          $table->bigInteger('to_user')->unsigned()->nullable();
          $table->bigInteger('consigner_user')->unsigned()->nullable();
          $table->float('value')->nullable();
          $table->bigInteger('type')->unsigned()->nullable();
          $table->bigInteger('details_type')->nullable();
          $table->bigInteger('category')->unsigned()->nullable();
          $table->bigInteger('office')->unsigned()->nullable();
          $table->bigInteger('typeservice')->unsigned()->nullable();
          $table->bigInteger('addcharge')->unsigned()->nullable();
          $table->bigInteger('promotion')->unsigned()->nullable();
          $table->integer('invoice')->nullable();
          $table->string('observation',255)->nullable();
          $table->bigInteger('last_event')->unsigned();
          $table->float('insurance')->nullable();
          $table->float('volumetricweightm')->nullable();
          $table->float('volumetricweighta')->nullable();
          $table->float('costservice')->nullable();
          $table->float('costinsurance')->nullable();
          $table->float('aditionalcost')->nullable();
          $table->float('subtotal')->nullable();
          $table->float('total')->nullable();
          $table->float('tax')->nullable();
          $table->float('pro')->nullable();
          $table->string('notes', 100)->nullable();
          $table->string('start_at',100)->nullable();
          $table->boolean('booked')->nullable();
          $table->string('process')->nullable();
          $table->bigInteger('user')->unsigned()->nullable();
          $table->timestamps();
          $table->softDeletes();
      });
      //
      Schema::table('pickup_orders', function($table) {
         $table->foreign('type')
          ->references('id')
          ->on('transport')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        $table->foreign('category')
          ->references('id')
          ->on('category')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        $table->foreign('to_user')
          ->references('id')
          ->on('user')
          ->onDelete('restrict')
          ->onUpdate('cascade');
        $table->foreign('from_user')
          ->references('id')
          ->on('user')
          ->onDelete('restrict')
          ->onUpdate('cascade');
        $table->foreign('consigner_user')
          ->references('id')
          ->on('user')
          ->onDelete('restrict')
          ->onUpdate('cascade');
        $table->foreign('last_event')
          ->references('id')
          ->on('event')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        $table->foreign('user')
          ->references('id')
          ->on('user')
          ->onDelete('cascade')
          ->onUpdate('cascade');
      });

      /**
         * Funcion de Validacion
         */
        DB::connection()->getPdo()->exec('
            drop function if exists seq_pickup_orders_func;
            create function seq_pickup_orders_func() returns bigint
              begin
                if(not(exists(select id from seq_details_pickup_order))) then
                  insert into seq_pickup_orders values (0);
                end if;
                update seq_pickup_orders set id = last_insert_id(id + 1);
                while exists(select null from pickup_orders where id = last_insert_id()) do
                  update seq_pickup_orders set id = last_insert_id(id + 1);
                end while;
                return last_insert_id();
              end
          ');
          /**
          * Creacion del trigger
          */
          DB::connection()->getPdo()->exec('
            drop trigger if exists seq_pickup_orders_trigger;
              create trigger seq_pickup_orders_trigger before insert on pickup_orders
                for each row
                  begin
                    if new.id is null or new.id = -1 then
                      set new.id = seq_pickup_orders_func();
                    end if;
                  end
          ');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
      Schema::drop('package');
    }
}
