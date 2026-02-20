<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;

use Laravel\Sanctum\HasApiTokens;

use Spatie\Permission\Traits\HasRoles;

class CustomerTable extends Authenticatable

{

    use HasApiTokens, HasFactory, Notifiable;

    /**

     * The attributes that are mass assignable.

     *

     * @var string[]

     */

    protected $guard="customer";

    protected $table="customer";

    protected $fillable = [

        'name',

        'user_name',

        'email',

        'password',

        'phone',

        'country',

        'city',

        'postcode',

        'state',

        'address',

        'scountry',

        'scity',

        'spostcode',

        'sstate',

        'saddress',

        'snote',

    ];

    /**

     * The attributes that should be hidden for serialization.

     *

     * @var array

     */

    protected $hidden = [

        'password',

        'remember_token',

    ];

    /**

     * The attributes that should be cast.

     *

     * @var array

     */

    protected $casts = [

        'email_verified_at' => 'datetime',

    ];

}
