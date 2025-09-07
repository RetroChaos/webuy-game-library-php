<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('developer', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
        });

        Schema::create('system', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
        });

        Schema::create('game', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('age_rating', 8);
            $table->string('box_art_uri', 255);
            $table->string('box_id', 32);

            $table->foreignId('developer_id')
                ->constrained('developer')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('system_id')
                ->constrained('system')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->index('developer_id');
            $table->index('system_id');
        });

        Schema::create('price_history', function (Blueprint $table) {
            $table->id();
            $table->dateTime('timestamp');
            $table->decimal('price', 5);

            $table->foreignId('game_id')
                ->constrained('game')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->index('game_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('price_history');
        Schema::dropIfExists('game');
        Schema::dropIfExists('system');
        Schema::dropIfExists('developer');
    }
};
