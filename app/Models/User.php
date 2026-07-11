<?php

namespace App\Models;

use Carbon\Traits\Creator;
use Dom\Comment;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'lastname',
        'email',
        'position_id',
        'password',
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
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function autoApprove()
    {
        return $this->position_id != 4;
    }

    public function communication(): HasOne
    {
        return $this->hasOne(Communication::class);
    }

    public function notices(): BelongsToMany
    {
        return $this->belongsToMany(Notice::class,'user_notice')->withPivot('read_at')->withTimestamps();
    }

    public function writers(): HasMany
    {
        return $this->hasMany(Article::class, 'writer_id','id');
    }

    public function editors(): HasMany
    {
        return $this->hasMany(Article::class, 'editor_id','id');
    }

    public function LikedComments(): BelongsToMany
    {
        return $this->belongsToMany(Comment::class, 'comment_user')->withTimestamps();
    }

    public function Comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class,'id','user_id');
    }


}
