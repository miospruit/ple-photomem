<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class memory extends Model
{
    public $table = 'memory';
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'description',
    ];

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function people()
    {
        return $this->hasMany(People::class);
    }
}
