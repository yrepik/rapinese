<?php

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
            $table->string('code', 10);
            $table->primary('code');
            $table->integer('brand_id')->unsigned();
            $table->foreign('brand_id')
                ->references('id')->on('brands')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('product_category_id')->unsigned();
            $table->foreign('product_category_id')
                ->references('id')->on('product_categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('material_id')->unsigned();
            $table->foreign('material_id')
                ->references('id')->on('materials')
                ->onDelete('cascade')
                ->onUpdate('cascade');            
            $table->string('name_es', 70);
            $table->string('name_en', 70);
            $table->string('name_pt', 70);
            $table->double('price_ars', 6, 2);
            $table->boolean('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products');
    }
}
