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
        Schema::create('esdeveniments', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->text('descripcio');
            $table->date('data');
            $table->time('hora');
            $table->integer('max_assistents');
            $table->integer('reserves')->default(0);
            $table->integer('edat_minima')->default(0);
            $table->string('imatge')->nullable();
            $table->foreignId('categoria_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('esdeveniments');
    }
};
