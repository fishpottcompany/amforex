<?php

namespace App\Models\v1;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{

    use HasApiTokens, Notifiable;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'customer_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id', 
        'customer_am_id_number',
        'customer_surname', 
        'customer_firstname', 
        'customer_othernames', 
        'customer_phone_number',
        'customer_email',
        'customer_nationality',
        'customer_id_1_type',
        'customer_id_1_number',
        'customer_id_2_type',
        'customer_id_2_number',
        'customer_id_3_type',
        'customer_id_3_number',
        'customer_flagged',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    //
}
