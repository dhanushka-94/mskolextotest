<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\LogsActivity;
use App\Models\ActivityLog;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, LogsActivity;

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
        'date_of_birth',
        'gender',
        'avatar',
        'profile_photo_path',
        'status',
        'role',
        'last_login_at',
        'settings',
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
            'date_of_birth' => 'date',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * Relationships
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Accessors
     */
    public function getIsAdminAttribute()
    {
        return $this->role === 'admin';
    }

    public function getIsActiveAttribute()
    {
        return $this->status === 'active';
    }

    public function getFullNameAttribute()
    {
        return $this->name;
    }

    public function getAvatarUrlAttribute()
    {
        // Check for profile_photo_path first, then avatar, then default
        if ($this->profile_photo_path) {
            return asset('storage/' . $this->profile_photo_path);
        }
        
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        
        return asset('images/avatars/default-avatar.svg');
    }

    public function getProfilePhotoUrlAttribute()
    {
        return $this->getAvatarUrlAttribute();
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCustomers($query)
    {
        return $query->where('role', 'customer');
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Activity Logging Methods
     */
    protected function getActivityType()
    {
        return $this->role === 'admin' ? ActivityLog::TYPE_ADMIN : ActivityLog::TYPE_CUSTOMER;
    }

    public function logLoginActivity()
    {
        return $this->logUserActivity(ActivityLog::ACTION_LOGIN, "User {$this->name} logged in");
    }

    public function logLogoutActivity()
    {
        return $this->logUserActivity(ActivityLog::ACTION_LOGOUT, "User {$this->name} logged out");
    }

    public function logPasswordChangeActivity()
    {
        return $this->logUserActivity(ActivityLog::ACTION_PASSWORD_CHANGED, "User {$this->name} changed password", [], ActivityLog::SEVERITY_HIGH);
    }

    public function logProfileUpdateActivity($changes = [])
    {
        return $this->logUserActivity(ActivityLog::ACTION_PROFILE_UPDATED, "User {$this->name} updated profile", [
            'updated_fields' => array_keys($changes)
        ]);
    }
}
