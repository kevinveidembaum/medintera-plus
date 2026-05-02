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
        Schema::create('medicamento_interacao', function (Blueprint $table) {
            $table->id('id_med_interacao');
            
            $table->foreignId('medicamento_origem')
                ->constrained('medicamento', 'id_medicamento')
                ->onDelete('cascade');
                
            $table->foreignId('medicamento_alvo')
                ->constrained('medicamento', 'id_medicamento')
                ->onDelete('cascade');
                
            $table->foreignId('id_interacao')
                ->nullable()
                ->constrained('interacao', 'id_interacao')
                ->onDelete('set null');
                
            $table->string('severidade', 50)->nullable();
            $table->text('descricao')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicamento_interacao');
    }
};
