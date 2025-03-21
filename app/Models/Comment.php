<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['body'];

    public function commentable() {
        return $this->morphTo();
    }
    public function comments() {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
