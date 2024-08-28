<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authors extends Model
{
    use HasFactory;

    protected $table = 'mst_authors';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'bio',
        'birth_date'
    ];
    
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'bio' => 'string',
        'birth_date' => 'date:Y-m-d',
    ];
}
