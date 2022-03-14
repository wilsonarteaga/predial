<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoJuego extends Model
{
    use HasFactory;
    protected $table = 'tipos_juegos';
    protected $primaryKey = 'ide_tju';
}
