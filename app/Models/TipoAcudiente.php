<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAcudiente extends Model
{
    use HasFactory;
    protected $table = 'tipos_acudientes';
    protected $primaryKey = 'ide_tac';
}
