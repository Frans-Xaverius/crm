<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationStatistics extends Model
{
    use HasFactory;

    protected $primaryKey = 'date';
    protected $fillable = [
        'date',
        'read_count',
        'unread_count',
        'solved_count',
        'unsolved_count',
        'ig_followers_count',
        'ig_likes_count',
        'ig_comments_count',
        'fb_likes_count',
        'fb_comments_count'
    ];
}
