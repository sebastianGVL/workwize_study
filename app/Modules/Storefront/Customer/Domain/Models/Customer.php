<?php

namespace App\Modules\Storefront\Customer\Domain\Models;

use App\Modules\Storefront\Customer\Infrastructure\Persistence\Factories\CustomerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property-read int $id
 * @property string $name
 * @property string $email
 * @property string $password
 */
class Customer extends Authenticatable
{
    /** @use HasFactory<CustomerFactory> */
    use HasApiTokens, Notifiable, HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return CustomerFactory
     */
    protected static function newFactory()
    {
        return new CustomerFactory();
    }
}
