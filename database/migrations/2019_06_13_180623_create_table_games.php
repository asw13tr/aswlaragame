<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableGames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('description')->nullable();
            $table->string('summary', 512)->nullable();
            $table->string('cover')->nullable();
            $table->string('game_file')->nullable();
            $table->string('game_url')->nullable();
            $table->string('game_code', 512)->nullable();
            $table->string('game_video')->nullable();
            $table->enum('game_screen', ['normal', 'fullsize'])->default('normal');
            $table->enum('game_scale', ["1x1", "4x3", "5x3", "2x1", "16x9", "1x2", "3x4", "3x5"])->default('4x3');
            $table->enum('status', ['published', 'draft', 'trash'])->default("published");
            $table->text('content')->nullable();
            $table->integer('views')->default(0);;
            $table->integer('like')->default(0);;
            $table->integer('dislike')->default(0);
            $table->string('allow_comments', 3)->default("on");
            $table->timestamps();
            $table->timestamp('p_time')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
