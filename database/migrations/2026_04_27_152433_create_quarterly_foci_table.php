<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quarterly_focuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('quarter', ['Q1', 'Q2', 'Q3', 'Q4']);
            $table->unsignedSmallInteger('year');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'quarter', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quarterly_focuses');
    }
};
