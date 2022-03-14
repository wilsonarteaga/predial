<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValoracionJuego extends Model
{
    use HasFactory;
    protected $table = 'valoraciones_juegos';
    protected $primaryKey = 'ide_val';
}
