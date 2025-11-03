<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use App\Traits\PopulateTenantID;
use App\Traits\TenantPermissionTrait;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;
use Vormkracht10\TwoFactorAuth\Enums\TwoFactorType;

class User extends Authenticatable implements FilamentUser, HasAvatar, HasMedia, MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use BelongsToTenant, HasFactory, HasRoles, InteractsWithMedia, Notifiable, PopulateTenantID, TenantPermissionTrait, TwoFactorAuthenticatable;

    const PROFILE = 'profile';

    const SUPER_ADMIN = 'super-admin';

    const ADMIN = 'admin';

    const CUSTOMER = 'customer';

    const AGENT = 'agent';

    const ROLES = [
        self::ADMIN,
        self::AGENT,
        self::CUSTOMER,
    ];

    // Gender

    const MALE = 1;

    const FEMALE = 2;

    const GENDERS = [
        self::MALE => 'Male',
        self::FEMALE => 'Female',
    ];

    // Marital Status

    const MARRIED = 1;

    const UNMARRIED = 0;

    const MARITAL_STATUS = [
        self::MARRIED => 'Married',
        self::UNMARRIED => 'Unmarried',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'gender',
        'created_by_id',
        'tenant_id',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
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
            'two_factor_type' => TwoFactorType::class,
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function getRoleAttribute()
    {
        return $this->roles()->first();
    }

    public function getProfileAttribute(): string
    {
        if (empty($this->getFirstMediaUrl(self::PROFILE))) {
            return asset('images/avatar.png');
        }

        return $this->getFirstMediaUrl(self::PROFILE);
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->getFirstMediaUrl(self::PROFILE);
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function address()
    {
        return $this->hasOne(UserAddress::class);
    }

    public function companyDetail()
    {
        return $this->hasOne(UserCompanyDetail::class);
    }

    public function companyDetails()
    {
        return $this->hasMany(UserCompanyDetail::class);
    }

    public function customerInsurances()
    {
        return $this->hasMany(Insurance::class, 'customer_id');
    }

    public function agentInsurances()
    {
        return $this->hasMany(Insurance::class, 'agent_id');
    }
}
