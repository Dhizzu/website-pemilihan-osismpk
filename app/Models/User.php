<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nis',
        'nisn',
        'class',
        'login_token',
    ];

    /**
     * Atribut yang harus disembunyikan untuk serialisasi.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Dapatkan atribut yang harus di-cast.
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
     * Dapatkan vote yang diberikan oleh user ini.
     */
    public function vote(): HasOne
    {
        return $this->hasOne(Vote::class);
    }

    /**
     * Cek apakah user sudah memberikan vote untuk OSIS.
     */
    public function hasVotedOSIS(): bool
    {
        return $this->vote()
            ->whereHas('candidate', function ($query) {
                $query->where('position', 'like', '%OSIS%');
            })
            ->exists();
    }

    /**
     * Cek apakah user sudah memberikan vote untuk MPK.
     */
    public function hasVotedMPK(): bool
    {
        return $this->vote()
            ->whereHas('candidate', function ($query) {
                $query->where('position', 'like', '%MPK%');
            })
            ->exists();
    }

    /**
     * Cek apakah user sudah memberikan vote (legacy method).
     */
    public function hasVoted(): bool
    {
        return $this->vote()->exists();
    }
}
