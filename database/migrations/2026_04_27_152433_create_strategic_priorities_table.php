<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('strategic_priorities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quarterly_focus_id')->constrained('quarterly_focuses')->cascadeOnDelete();
            $table->string('title');
            $table->string('owner')->nullable();
            $table->string('kpi')->nullable();
            $table->enum('status', ['on_track', 'at_risk', 'off_track'])->default('on_track');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('strategic_priorities');
    }
};
