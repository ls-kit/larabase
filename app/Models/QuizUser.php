<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizUser extends Model
{
    protected $table = 'quiz_user'; // (table name, singular, recommended for pivot tables)

    protected $fillable = [
        'user_id',
        'quiz_id',
        'status',
        'points',
        'completed_at',
    ];

    public $timestamps = true;
}

