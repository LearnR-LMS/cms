<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class EFCourse extends Model
{
    protected $table = 'ef_courses';
    const IS_DELETED = 1;

    protected $fillable = [
        'id', 'name', 'total_time_learning', 'total_question', 'is_deleted'
    ];

    public function user() {
        return $this->belongsToMany(User::class, 'ef_scores', 'ef_course_id', 'user_id');
    }
}
