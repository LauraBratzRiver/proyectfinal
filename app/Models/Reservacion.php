<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservacion extends Model
{
    use HasFactory;
    protected $table = 'reservacion';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'apellido',
        'reservacion',

    ];
};
