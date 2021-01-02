<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BlogAssignedTags extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::dropIfExists('blog_assigned_tags');
        Schema::create('blog_assigned_tags', function (Blueprint $table) {
            $table->integer('blog_id');
            $table->integer('tag_id');
            $table->timestamps();

            $table->primary(['blog_id', 'tag_id']);

            $table->foreign('blog_id')->references('id')->on('blogs');
            $table->foreign('tag_id')->references('id')->on('blog_tags');
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
