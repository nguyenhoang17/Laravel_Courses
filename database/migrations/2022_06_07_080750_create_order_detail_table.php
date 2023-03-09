<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->string('name');
            $table->integer('category_id');
            $table->integer('staff_id');
            $table->string('image');
            $table->string('video')->nullable();
            $table->integer('type');
            $table->text('file')->nullable();
            $table->bigInteger('start_time');
            $table->bigInteger('end_time');
            $table->text('description')->nullable();
            $table->timestamp('publiced_at')->nullable();
            $table->string('price');
            $table->string('key')->nullable();
            $table->integer('is_live');
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
        Schema::dropIfExists('order_detail');
    }
}
