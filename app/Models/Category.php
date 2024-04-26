<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categorie';

    protected $guarded = [''];

    function jenis()
    {
        return $this->hasMany(Jenis::class, 'category_id', 'id');
    }
}
