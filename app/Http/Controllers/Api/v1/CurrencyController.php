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

    public function get_one_currency($column_name, $column_value)
    {
        return  DB::table('currencies')->where($column_name, '=', $column_value)->get();
    }


    public function update_currency($currency_id, $currency_full_name, $currency_abbreviation, $currency_symbol, $currency_flagged, $user_id){

        $currency = Currency::find($currency_id);
        $currency->currency_full_name = $currency_full_name;
        $currency->currency_abbreviation = $currency_abbreviation;
        $currency->currency_symbol = $currency_symbol;
        $currency->currency_flagged = $currency_flagged;
        $currency->admin_id = $user_id;
        $currency->save();
    }
}
