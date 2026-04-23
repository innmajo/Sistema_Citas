<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Producto extends Model
{
    protected $fillable = [
        'producto',
        'referencia',
        'description',
        'cantidad',
        'precio_und'
    ];
    protected $table = 'productos';
}

