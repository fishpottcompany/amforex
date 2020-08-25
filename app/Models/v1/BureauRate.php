<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class BureauRate extends Model
{
    
    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bureau_rates';


    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'bureau_rate_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bureau_rate_id', 
        'bureau_rate_ext_id', 
        'currency_from_id', 
        'currency_to_id', 
        'rate', 
        'worker_id',
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
