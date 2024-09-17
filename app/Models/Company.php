<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'logo'];

    // Relación con el modelo VCard (una empresa tiene muchas vCards)
    public function vcards()
    {
        return $this->hasMany(VCard::class);
    }
}
