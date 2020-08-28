<?php

namespace App\Models\v1;

use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Trade extends Model
{
    
    use HasApiTokens, Notifiable;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'trade_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'trade_id', 
        'trade_currency_in_id', 
        'trade_currency_in_old_stock',
        'trade_currency_in_new_stock',
        'trade_currency_in_amount', 
        'trade_currency_out_id', 
        'trade_currency_out_old_stock',
        'trade_currency_out_new_stock',
        'trade_currency_out_amount', 
        'trade_bureau_rate', 
        'trade_bog_rate', 
        'trade_flagged',
        'customer_id_1_id',
        'branch_id',
        'bureau_id',
        'worker_id',
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
