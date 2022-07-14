<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class EFScore extends Model
{
    protected $table = 'ef_scores';

    const PENDING_EARN = 1;
    const REJECTED_EARN = 2;
    const APPROVED_EARN = 3;

    protected $fillable = [
        'ef_course_id', 'user_id', 'score', 'earn_status'
    ];
}
