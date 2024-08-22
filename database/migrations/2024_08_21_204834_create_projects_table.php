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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            $table->string('description');
            $table->enum('state', [
                'AC', // Acre
                'AL', // Alagoas
                'AP', // Amapá
                'AM', // Amazonas
                'BA', // Bahia
                'CE', // Ceará
                'DF', // Distrito Federal
                'ES', // Espírito Santo
                'GO', // Goiás
                'MA', // Maranhão
                'MT', // Mato Grosso
                'MS', // Mato Grosso do Sul
                'MG', // Minas Gerais
                'PA', // Pará
                'PB', // Paraíba
                'PR', // Paraná
                'PE', // Pernambuco
                'PI', // Piauí
                'RJ', // Rio de Janeiro
                'RN', // Rio Grande do Norte
                'RS', // Rio Grande do Sul
                'RO', // Rondônia
                'RR', // Roraima
                'SC', // Santa Catarina
                'SP', // São Paulo
                'SE', // Sergipe
                'TO'  // Tocantins
            ]);

            $table->enum('installation_type', [
                'Fibrocimento (Madeira)',
                'Fibrocimento (Metálico)',
                'Cerâmico',
                'Metálico',
                'Laje',
                'Solo'
            ]);

            $table->json('equipments');

            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
