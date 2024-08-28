<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'mst_books';
    protected $fillable = [
        'id',
        'title',
        'description',
        'publish_date',
        'author_id'
    ];

    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'description' => 'string',
        'publish_date' => 'date:Y-m-d',
        'author_id' => 'integer',
    ];
}
