<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
  Schema::create('user_dog_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('breed_name', 100);
            $table->string('image_url', 500);
            $table->timestamps();
            
            // Unique constraint to prevent duplicate likes
            $table->unique(['user_id', 'breed_name']);
            
            // Indexes for better query performance
            $table->index('breed_name');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_dog_likes');
    }
};
