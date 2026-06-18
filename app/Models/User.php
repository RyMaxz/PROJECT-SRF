<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
//use Database\Factories\UserFactory;
use Filament\Panel;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    //** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    // cuman admin yg bisa akses
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole('super_admin');
    }

    // kolom yang bisa diisi
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
    ];

    // Daftar kolom yang DISIMPAN tapi TIDAK BOLEH tampil di hasil JSON/API
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

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}