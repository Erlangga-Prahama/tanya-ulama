<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'user_id',
        'content',
    ];

    // relation
    public function question()
    {
        # code...
        return $this->belongsTo(Question::class);
    }

    public function user()
    {
        # code...
        return $this->belongsTo(User::class);
    }

    public function reports()
    {
        # code...
        return $this->morphMany(Report::class, 'reportable');
    }
}
