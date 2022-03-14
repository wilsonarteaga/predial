<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JuegoPaciente extends Model
{
    use HasFactory;
    protected $table = 'juegos_pacientes';
    protected $primaryKey = 'ide_jpa';
}
