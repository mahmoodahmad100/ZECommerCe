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
            $table->increments('id');
            $table->integer('user_id');
            #$table->integer('category_id');
            $table->string('name');
            $table->string('price');
            $table->text('description');
            $table->string('coupon_code')->nullable();
            $table->integer('coupon_amount')->nullable();
            $table->integer('coupon_how_many_times')->nullable();
            $table->integer('coupon_how_many_used')->nullable();
            $table->date('coupon_expires_at')->nullable();
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
