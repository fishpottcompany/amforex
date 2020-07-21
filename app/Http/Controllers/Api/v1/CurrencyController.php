<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\v1\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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

    public function get_all_currencies()
    {
        return DB::table('currencies')
            ->join('administrators', 'currencies.admin_id', '=', 'administrators.admin_id')
            ->select('currencies.*', 'administrators.admin_surname', 'administrators.admin_firstname')
            ->get();
    }
}
