<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('code');
            $table->string('name');
            $table->text('description');
            $table->string('health_registration');
            $table->date('date_dispatch');
            $table->date('expiration_date');
            $table->string('unity');
            $table->string('via_administration');
            $table->string('concentration');
            $table->string('pharmaceutical_form');
            $table->text('image')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
