<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Bureau extends Model
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
        'bureau_id', 
        'bureau_name', 
        'bureau_hq_gps_address', 
        'bureau_hq_location', 
        'bureau_tin',
        'bureau_license_no',
        'bureau_registration_num',
        'bureau_phone_1',
        'bureau_phone_2',
        'bureau_email_1',
        'bureau_email_2',
        'bureau_flagged',
        'admin_id',
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
