<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'reportable_type',
        'reportable_id',
        'reporter_id',
        'reason',
        'description',
        'status',
        'admin_note',
        'resolved_at',
        'resolved_by',
    ];
    
    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    // relation
    public function reportable()
    {
        # code...
        return $this->morphTo();
    }

    public function reporter()
    {
        # code...
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function resolver()
    {
        # code...
        return $this->belongsTo(User::class, 'resolved_by');
    }

    // helper
    public function isPending()
    {
        # code...
        return $this->status === 'pending';
    }

    public function approve($adminNote = null)
    {
        # code...
        $this->update([
            'status' => 'approved',
            'admin_note' => $adminNote,
            'resolved_at' => now(),
            'resolved_by' => auth(),
        ]);
    }

    public function reject($adminNote = null)
    {
        # code...
        $this->update([
            'status' => 'approved',
            'admin_note' => $adminNote,
            'resolved_at' => now(),
            'resolved_by' => auth(),
        ]);
    }
}
