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

    // Buat agar hanya EMAIL @project.co yang bisa AKSES ke panel admin
    public function canAccessPanel(Panel $panel): bool
    {
        return str_ends_with($this->email, '@project.co');
    }

    // Daftar kolom yang BOLEH diisi lewat input form (keamanan data)
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
}