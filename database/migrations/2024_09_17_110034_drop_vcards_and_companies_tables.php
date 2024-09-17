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
        Schema::dropIfExists('vcards');  // Eliminar la tabla 'vcards'
        Schema::dropIfExists('companies');  // Eliminar la tabla 'companies'
    }
    
    public function down()
    {
        // Si necesitas restaurarlas, puedes definir aquí el código para volver a crearlas.
    }
    
};
