<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_type_services', function (Blueprint $table) {
            $table->id()->unsigned(false);
            $table->integer('product_type_id');
            $table->foreign('product_type_id')->references('id')->on('product_types')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('service_type_id');
            $table->foreign('service_type_id')->references('id')->on('services')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('product_type_services');
    }
};
