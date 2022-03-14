<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcudientePaciente extends Model
{
    use HasFactory;
    protected $table = 'pacientes_has_acudientes';
    protected $primaryKey = 'ide_paa';
}
