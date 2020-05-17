<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharacteristicProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('characteristic_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('characteristic_id');
            $table->foreign('characteristic_id')->references('id')->on('characteristics')->onDelete('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
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
        Schema::table('characteristic_product', function (Blueprint $table) {
            $table->dropForeign(['characteristic_id']);
            $table->dropForeign(['product_id']);
        });
        Schema::dropIfExists('characteristic_product');
    }
}
