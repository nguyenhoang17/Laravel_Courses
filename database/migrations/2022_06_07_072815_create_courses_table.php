<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('category_id');
            $table->integer('staff_id')->nullable();
            $table->string('image');
            $table->string('video')->nullable();
            $table->integer('type');
            $table->string('key')->nullable();
            $table->bigInteger('start_time');
            $table->bigInteger('end_time');
            $table->text('description')->nullable();
            $table->integer('status')->default(0);
            $table->integer('is_featured')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->string('price');
            $table->integer('start_live')->nullable();
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
        Schema::dropIfExists('courses');
    }
}
