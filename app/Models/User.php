<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;

class User extends Authenticatable // implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'gender',               
        'profession',           
        'is_verified',          
        'verified_at',          
        'verification_document', 
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    public function questions() 
    {
        return $this->hasMany(Question::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function answeredQuestions()
    {
        return $this->hasMany(Question::class, 'answered_by');
    }

    public function reports()
    {
        # code...
        return $this->hasMany(Report::class, 'reporter_id');
    }

    public function resolvedReports()
    {
        # code...
        return $this->hasMany(Report::class, 'resolved_by');
    }

    //Helper
    public function isExpert()
    {
        # code...
        return $this->hasRole(['ustaz', 'ustazah']) && $this->is_verified;
    }

    public function isAdmin()
    {
        # code...
        return $this->hasRole('admin');
    }

    public function canAnswerQuestions()
    {
        # code...
        return $this->isExpert();
    }
}
