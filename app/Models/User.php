<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Relación con Citas
     */
    public function citas()
    {
        return $this->hasMany(Cita::class, 'usuarioId');
    }

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

    // Métodos auxiliares para verificar roles
    public function isAdmin()
    {
        return $this->admin === 1; // 1 = Admin, 0 = Usuario
    }

    public function isEditor()
    {
        return $this->role === 'editor';
    }

    public function isUsuario()
    {
        return $this->role === 'usuario';
    }
}
