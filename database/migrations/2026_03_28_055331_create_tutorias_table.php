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
            Schema::create('tutorias', function (Blueprint $table) {
                $table->id();
                $table->foreignId('alumno_id')->constrained();
                $table->foreignId('tutor_id')->nullable()->constrained();
                $table->string('tema');
                $table->text('descripcion');
                $table->timestamp('fecha');
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutorias');
    }
};
