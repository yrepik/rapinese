<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->integer('id')->unsigned()->primary()->increments();
            $table->string('product_code', 10);
            $table->foreign('product_code')
                ->references('code')
                ->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('filename', 60);
            $table->index(['product_code', 'filename']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('product_images');
    }
}
