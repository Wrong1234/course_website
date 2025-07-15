<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('order')->default(1);
            $table->string('duration')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('modules');
    }
};