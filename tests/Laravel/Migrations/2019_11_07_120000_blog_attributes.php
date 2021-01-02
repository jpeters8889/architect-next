<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BlogAttributes extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::dropIfExists('blog_attributes');
        Schema::create('blog_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('blog_id');
            $table->string('first');
            $table->string('second');
            $table->timestamps();

            $table->foreign('blog_id')->references('id')->on('blogs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('blog_attributes');
    }
}
