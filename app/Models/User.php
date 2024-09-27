<?php

namespace App\Models;

use App\Enums\Role;
use App\Enums\Config as ConfigEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'is_active',
        'profile_picture',
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
        'email_verifikasi' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Get the user's profile picture
     *
     * @return Attribute
     */
    public function profilePicture(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if ($value) return $value;

                $url = 'https://ui-avatars.com/api/?background=6D67E4&color=fff&name=';
                return $url . urlencode($this->name);
            },
        );
    }

    // Mutator untuk memastikan phone hanya angka
    public function setPhoneAttribute($value)
    {
        // Hanya menyimpan angka, menghapus karakter yang bukan angka
        $this->attributes['phone'] = preg_replace('/\D/', '', $value);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeRole($query, Role $role)
    {
        return $query->where('role', $role->status());
    }

    public function scopeSearch($query, $search)
    {
        return $query->when($search, function($query, $find) {
            return $query
                ->where('name', 'LIKE', $find . '%')
                ->orWhere('phone', $find)
                ->orWhere('email', $find);
        });
    }

    public function scopeRender($query, $search)
    {
        return $query
            ->search($search)
            ->role(Role::STAFF)
            ->paginate(Config::getValueByCode(ConfigEnum::PAGE_SIZE))
            ->appends([
                'search' => $search,
            ]);
    }

    /**
     * Check if the user is an admin
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === Role::ADMIN->status(); 
    }

    /**
     * Check if the user is a staff
     *
     * @return bool
     */
    public function isStaff(): bool
    {
        return $this->role === Role::STAFF->status(); 
    }
}
