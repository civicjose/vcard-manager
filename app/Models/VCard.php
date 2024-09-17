<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VCard extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'vcards';  // Especifica el nombre correcto de la tabla

    protected $fillable = ['name', 'lastname', 'position', 'phone', 'email', 'company_id', 'image'];

    // Relación con el modelo Company (una vCard pertenece a una empresa)
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}



