<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
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
        'email',
        'password',
        'role',
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
     * Vérifier si l'utilisateur est admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isManager(): bool
    {
        return $this->role === 'manager';
    }

    public function isReader(): bool
    {
        return $this->role === 'reader';
    }

    public function canManageMembers(): bool
    {
        return in_array($this->role, ['admin', 'manager'], true);
    }

    public function canManageCotisations(): bool
    {
        return in_array($this->role, ['admin', 'manager'], true);
    }

    public function canManageDepenses(): bool
    {
        return in_array($this->role, ['admin', 'manager'], true);
    }

    public function canManageUsers(): bool
    {
        return $this->isAdmin();
    }

    public function depenses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Depense::class, 'created_by');
    }
}