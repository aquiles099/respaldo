<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TransportersTable extends Migration
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
        Schema::create('seq_transporters', function (Blueprint $table)
        {
           $table->bigInteger('id');
        });
        /**
        * Estructura de la tabla
        */
        Schema::create('transporters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('name');
            $table->string('identification');
            $table->string('phone');
            $table->string('fax');
            $table->string('email');
            $table->string('account_number');
            $table->string('web');
            $table->string('name_contac');
            $table->string('lastname_contac');
            $table->string('exportation');   
            $table->string('divition'); 
            $table->string('address_street'); 
            $table->string('address_city'); 
            $table->string('address_country'); 
            $table->string('address_state'); 
            $table->string('address_code'); 
            $table->string('address_port');
            $table->string('billing_address_street');  
            $table->string('billing_address_city'); 
            $table->string('billing_address_country'); 
            $table->string('billing_address_state'); 
            $table->string('billing_address_code'); 
            $table->string('billing_address_port'); 
            $table->string('payments_term_terms'); 
            $table->string('payments_term_pays'); 
            $table->string('payments_term_coin'); 
            $table->string('payments_term_creditlimit'); 
            $table->string('payments_term_bill'); 
            $table->string('attachments'); 
            $table->string('note'); 
            $table->bigInteger('transport')->unsigned()->nullable();
            $table->string('numberfmc'); 
            $table->string('numberscac'); 
            $table->string('numberiata'); 
            $table->string('codeair'); 
            $table->string('numbercodeair'); 
            $table->string('guidenumber'); 
            $table->Integer('operator');
            $table->timestamps();
            $table->softDeletes();
        });

             /**
        * Relacion con transporte
        */
        Schema::table('transporters', function($table) {
          $table->foreign('transport')
           ->references('id')
           ->on('transport')
           ->onDelete('cascade')
           ->onUpdate('cascade');
        });

         /**
        * Funcion de Validacion
        */
        DB::connection()->getPdo()->exec('
          drop function if exists seq_transporters_func;
          create function seq_transporters_func() returns bigint
            begin
              if(not(exists(select id from seq_transporters))) then
                insert into seq_transporters values (0);
              end if;
              update seq_transporters set id = last_insert_id(id + 1);
              while exists(select null from transporters where id = last_insert_id()) do
                update seq_transporters set id = last_insert_id(id + 1);
              end while;
              return last_insert_id();
            end
        ');
        /**
        * Creacion del trigger
        */
        DB::connection()->getPdo()->exec('
          drop trigger if exists seq_transporters_trigger;
            create trigger seq_transporters_trigger before insert on transporters
              for each row
                begin
                  if new.id is null or new.id = -1 then
                    set new.id = seq_transporters_func();
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
      DB::connection()->getPdo()->exec('drop trigger if exists seq_transporters_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_transporters_func');
      Schema::drop('transporters');
      Schema::drop('seq_transporters');
    }
}


