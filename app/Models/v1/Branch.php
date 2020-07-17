<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Branch extends Model
{

    use Notifiable;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'bureau_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'branch_id', 
        'branch_gps_location', 
        'branch_address',  
        'branch_flagged',
        'parent_bureau_id',
        'creator_id',
        'bureau_phone_1',
        'bureau_phone_2',
        'bureau_email_1',
        'bureau_email_2',
        'bureau_flagged',
        'created_at',
        'updated_at',
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
