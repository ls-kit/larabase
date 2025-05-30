<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonUser extends Model
{
    //
    protected $table = 'lesson_user';
    protected $fillable = [
    'user_id',
    'lesson_id',
    'status',
    'points',
    'completed_at',
    ];

}
