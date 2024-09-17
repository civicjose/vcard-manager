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
        Schema::table('vcards', function (Blueprint $table) {
            // Añadir el campo "puesto" si no existe
            if (!Schema::hasColumn('vcards', 'position')) {
                $table->string('position')->after('lastname');
            }
    
            // Añadir la clave foránea "company_id" solo si no existe
            if (!Schema::hasColumn('vcards', 'company_id')) {
                $table->foreignId('company_id')->nullable()->constrained('companies')->onDelete('set null');
            }
        });
    }
    
    public function down()
    {
        Schema::table('vcards', function (Blueprint $table) {
            // Eliminar los campos si se hace rollback
            if (Schema::hasColumn('vcards', 'position')) {
                $table->dropColumn('position');
            }
    
            if (Schema::hasColumn('vcards', 'company_id')) {
                $table->dropForeign(['company_id']);
                $table->dropColumn('company_id');
            }
        });
    }
    
};
