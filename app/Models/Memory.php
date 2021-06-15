<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memory extends Model
{
    public $table = 'memory';
    protected $with = ['tags'];
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'description',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function people()
    {
        return $this->belongsToMany(People::class);
    }

}
