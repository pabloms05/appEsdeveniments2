<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
    ];

    protected $table = 'categorias';

    // 🔗 Una categoria té molts esdeveniments
    public function esdeveniments() {
        return $this->hasMany(Esdeveniment::class);
    }
}
