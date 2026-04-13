<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

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
        'answered_at' => 'datetime',
    ];

    //relation
    public function user()
    {
        # code...
        return $this->belongsTo(User::class);
    }

    public function answered()
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

        // Accessor untuk 100 kata
    public function getShortContentAttribute()
    {
        return Str::words($this->content, 26, '...');
    }
    
    // Accessor dengan parameter dinamis
    public function getExcerptAttribute($length = 100)
    {
        return Str::words($this->content, $length, '...');
    }
}
