<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Cviebrock\EloquentSluggable\Sluggable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Jeffgreco13\FilamentBreezy\Traits\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Wildside\Userstamps\Userstamps;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    use HasApiTokens, HasFactory, HasPanelShield, HasRoles, Notifiable, Sluggable, SoftDeletes, TwoFactorAuthenticatable, Userstamps;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug', // Add 'slug' to the fillable array
        'surname',
        'email',
        'password',
        'avatar',
        'phone',
        'name', 'email', 'password',
        'two_factor_code', 'two_factor_expires_at',
        'login_count', 'last_login_at', 'first_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['name', 'surname'],
            ],
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar ? Storage::url($this->avatar) : null;
    }

    public function generateTwoFactorCode(): void
    {
        $this->timestamps = false;  // Prevent updating the 'updated_at' column
        $this->two_factor_code = rand(100000, 999999);  // Generate a random code
        $this->two_factor_expires_at = now()->addMinutes(10);  // Set expiration time
        $this->save();
    }

    public function resetTwoFactorCode(): void
    {
        $this->timestamps = false;
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }

    public function hasTwoFactorCode()
    {
        // Vérifiez si l'utilisateur a un code de vérification à deux facteurs
        return ! empty($this->two_factor_code);
    }
}
