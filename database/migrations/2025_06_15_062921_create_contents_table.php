<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->enum('type', ['text', 'video', 'image', 'link', 'file', 'assignment', 'quiz'])->default('text');
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->string('url')->nullable();
            $table->string('file_path')->nullable();
            $table->decimal('file_size', 8, 2)->nullable();
            $table->string('alt_text')->nullable();
            $table->boolean('external')->default(false);
            $table->integer('duration')->nullable();
            $table->integer('order')->default(1);
            $table->string('video_length')->nullable(); // Optional field for video length
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contents');
    }
};