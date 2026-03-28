<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'category',
        'is_answered',
        'answered_by',
        'answered_at',
    ];

    protected $casts = [
        'is_answered' => 'boolean',
        'answered_at' => 'datetme',
    ];

    //relation
    public function user()
    {
        # code...
        return $this->belongsTo(User::class);
    }

    public function answerd()
    {
        # code...
        return $this->hasOne(Answer::class);
    }

    public function answeredBy()
    {
        # code...
        return $this->belongsTo(User::class, 'answered_by');
    }

    public function reports()
    {
        # code...
        return $this->morphMany(Report::class, 'reportable');
    }

    // helper
    public function markAsAnswered(User $expert)
    {
        # code...
        $this->update([
            'is_answered' => true,
            'answered_by' => $expert->id,
            'answered_at' => now(),
        ]);
    }

    public function canBeAnswered()
    {
        # code...
        return !$this->is_answered;
    }
}
