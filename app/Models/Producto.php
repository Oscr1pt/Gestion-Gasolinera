<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'codigo_barras',
        'precio_venta',
        'costo',
        'stock_actual',
        'categoria',
        'imagen_url',
    ];
}
