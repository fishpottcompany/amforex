<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\v1\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    
    public function add_currency($currency_full_name, $currency_abbreviation, $currency_symbol, $user_id)
    {
        $currency = new Currency();
        $currency->currency_full_name = $currency_full_name; 
        $currency->currency_abbreviation = $currency_abbreviation;
        $currency->currency_symbol = $currency_symbol;
        $currency->currency_flagged = false;
        $currency->admin_id = $user_id;
        $currency->save();
    }

}
