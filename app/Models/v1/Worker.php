<?php

namespace App\Models\v1;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Worker extends Authenticatable
{

    use HasApiTokens, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'workers';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'worker_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'worker_id', 
        'worker_ext_id',
        'worker_surname', 
        'worker_firstname', 
        'worker_othernames', 
        'worker_home_gps_address', 
        'worker_home_location', 
        'worker_position', 
        'worker_scope', 
        'worker_phone_number',
        'worker_email',
        'worker_pin',
        'password',
        'worker_flagged',
        'worker_was_first',
        'creator_user_type',
        'creator_id',
        'branch_id',
        'bureau_id',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'worker_pin', 'remember_token',
        'password', 'remember_token',
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
