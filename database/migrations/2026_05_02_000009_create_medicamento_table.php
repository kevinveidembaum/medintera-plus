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
        Schema::create('medicamento', function (Blueprint $table) {
            $table->id('id_medicamento');
            $table->string('nome_comercial', 255);
            
            $table->foreignId('id_principio_ativo')
                ->nullable()
                ->constrained('principio_ativo', 'id_principio_ativo')
                ->onDelete('set null');
                
            $table->foreignId('id_classificacao')
                ->nullable()
                ->constrained('classificacao_medicamento', 'id_classificacao')
                ->onDelete('set null');
                
            $table->foreignId('id_sintomatologia')
                ->nullable()
                ->constrained('sintomatologia', 'id_sintomatologia')
                ->onDelete('set null');
                
            $table->foreignId('id_alt_lab')
                ->nullable()
                ->constrained('alteracao_laboratorial', 'id_alt_lab')
                ->onDelete('set null');
                
            $table->foreignId('id_interacao')
                ->nullable()
                ->constrained('interacao', 'id_interacao')
                ->onDelete('set null');
                
            $table->foreignId('id_acao_med')
                ->nullable()
                ->constrained('acao_medicina', 'id_acao_med')
                ->onDelete('set null');
                
            $table->foreignId('id_acao_nut')
                ->nullable()
                ->constrained('acao_nutricao', 'id_acao_nut')
                ->onDelete('set null');
                
            $table->foreignId('id_acao_enf')
                ->nullable()
                ->constrained('acao_enfermagem', 'id_acao_enf')
                ->onDelete('set null');
                
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicamento');
    }
};
