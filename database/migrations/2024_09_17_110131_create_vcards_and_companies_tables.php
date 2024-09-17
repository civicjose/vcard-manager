<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Crear la tabla de empresas
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo')->nullable();  // Logo de la empresa en formato SVG
            $table->timestamps();
        });
    
        // Crear la tabla de vCards
        Schema::create('vcards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('lastname');
            $table->string('position');  // Puesto de la persona
            $table->string('phone');  // Teléfono con formato internacional
            $table->string('email');
            $table->foreignId('company_id')->nullable()->constrained('companies')->onDelete('set null');  // Relación con la tabla 'companies'
            $table->string('image')->nullable();  // Foto de perfil
            $table->timestamps();
        });
    }
    
    public function down()
    {
        // Eliminar las tablas si se hace rollback
        Schema::dropIfExists('vcards');
        Schema::dropIfExists('companies');
    }
    
};
