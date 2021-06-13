<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function memory()
    {
        return $this->morphedByMany(Memory::class, 'taggable');
    }
}
