<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Blogs extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::dropIfExists('blogs');
        Schema::create('blogs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_id')->default(1);
            $table->string('title');
            $table->text('body')->unique();
            $table->text('slug')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}
