<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaseTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function(Blueprint $table){

            $table->integer('id');
            $table->date('date');
            $table->integer('views');

            $table->index('id');
        });

        Schema::create('leads', function(Blueprint $table){
            $table->integer('id');
            $table->date('birthDate');
            $table->integer('adId')->unsigned();
            $table->string('state');
            $table->dateTime('createdAt');

            $table->index(['adId','id']);
        });

        Schema::create('orders', function(Blueprint $table){
            $table->integer('id');
            $table->integer('leadId')->unsigned();
            $table->decimal('unitPrice');
            $table->integer('quantity');
            $table->decimal('shippingCost');

            $table->index(['leadId','id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ads');
        Schema::drop('leads');
        Schema::drop('orders');
    }


    /**
     * Cleans out all the table and gets things set to start from scratch
     *
     * @return bool
     */
    public function cleanTable()
    {
        return true;
    }
}
