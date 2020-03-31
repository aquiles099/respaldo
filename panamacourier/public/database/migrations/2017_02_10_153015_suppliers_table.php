<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SuppliersTable extends Migration
{ 

    public function up()
    {

        /**
         * Tabla para la sequencia
        */
        Schema::create('seq_suppliers', function (Blueprint $table)
        {
           $table->bigInteger('id');
        });
        /**
        * Estructura de la tabla
        */
        Schema::create('suppliers', function (Blueprint $table) {
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
            $table->Integer('operator');
            $table->timestamps();
            $table->softDeletes();
        });

         /**
        * Funcion de Validacion
        */
        DB::connection()->getPdo()->exec('
          drop function if exists seq_suppliers_func;
          create function seq_suppliers_func() returns bigint
            begin
              if(not(exists(select id from seq_suppliers))) then
                insert into seq_suppliers values (0);
              end if;
              update seq_suppliers set id = last_insert_id(id + 1);
              while exists(select null from suppliers where id = last_insert_id()) do
                update seq_suppliers set id = last_insert_id(id + 1);
              end while;
              return last_insert_id();
            end
        ');
        /**
        * Creacion del trigger
        */
        DB::connection()->getPdo()->exec('
          drop trigger if exists seq_suppliers_trigger;
            create trigger seq_suppliers_trigger before insert on suppliers
              for each row
                begin
                  if new.id is null or new.id = -1 then
                    set new.id = seq_suppliers_func();
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
      DB::connection()->getPdo()->exec('drop trigger if exists seq_suppliers_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_suppliers_func');
      Schema::drop('suppliers');
      Schema::drop('seq_suppliers');
    
    }
}
