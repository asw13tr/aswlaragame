<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBlogArticles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('keywords', 1024)->nullable();
            $table->text('description')->nullable();
            $table->text('summary')->nullable();
            $table->string('author')->nullable();
             $table->enum('status', ['published', 'draft', 'trash'])->default("published");
            $table->text('content')->nullable();
            $table->integer('views')->default(0);
            $table->string('cover')->nullable();
            $table->string('video')->nullable();
            $table->string('hide_cover', 3)->default("off");
            $table->string('allow_comments', 3)->default("on");
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
        Schema::dropIfExists('articles');
    }
}
