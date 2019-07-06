<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('description')->nullable();
            $table->text('content')->nullable();
            $table->string('cover')->nullable();
            $table->string('video')->nullable();
            $table->integer('parent')->default(0);
            $table->integer('views')->default(0);
            $table->enum('status', ['published', 'draft', 'trash'])->default("published");
            $table->string('hide_cover', 3)->default("off");
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
        Schema::dropIfExists('pages');
    }
}
