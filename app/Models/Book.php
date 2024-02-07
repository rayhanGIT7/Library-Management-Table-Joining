<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Book_genre;
use App\Models\Author;
class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'author_id',
        'genre',
        'publication_year',
        'availability',
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}

