<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Esdeveniment extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'descripcio',
        'data',
        'hora',
        'max_assistents',
        'reserves',
        'edat_minima',
        'imatge',
        'categoria_id',
    ];

    // protected $casts = [
    //     'data' => 'date',
    //     'hora' => 'datetime:H:i',
    // ];

    // Cada esdeveniment pertany a una categoria
    public function categoria() {
        return $this->belongsTo(Categoria::class);
    }

    // Cada esdeveniment pot tenir molts usuaris
    public function usuaris() {
        return $this->belongsToMany(User::class);
    }
}
