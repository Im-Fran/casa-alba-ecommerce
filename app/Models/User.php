<?php

namespace App\Models;

use App\Observers\UserObserver;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Lunar\Base\LunarUser as LunarUserInterface;
use Lunar\Base\Traits\LunarUser;
use Lunar\Models\Customer;

#[ObservedBy([UserObserver::class])]
class User extends Authenticatable implements LunarUserInterface, MustVerifyEmail {
    use HasFactory,
        LunarUser,
        Notifiable;

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'phone',
        'rut',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function selfCustomer(): Customer {
        return $this->customers()->firstOrCreate([
            'vat_no' => $this->rut
        ], [
            'first_name' => $this->name,
            'last_name' => $this->last_name,
        ]);
    }

    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
