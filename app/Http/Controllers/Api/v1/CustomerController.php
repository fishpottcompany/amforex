<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\v1\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function add_customer($customer_amforex_id_number, $customer_surname, $customer_firstname, $customer_othernames, $customer_phone_number, $customer_email, $customer_nationality, $customer_id_1_type, $customer_id_1_number,  $worker_bureau_id, $user_id)
    {
        $customer = new Customer();
        $customer->customer_am_id_number = $customer_amforex_id_number;
        $customer->customer_surname = $customer_surname;
        $customer->customer_firstname = $customer_firstname;
        $customer->customer_othernames = $customer_othernames;
        $customer->customer_phone_number = $customer_phone_number;
        $customer->customer_email = $customer_email;
        $customer->customer_nationality = $customer_nationality;
        $customer->customer_id_1_type = $customer_id_1_type;
        $customer->customer_id_1_number = $customer_id_1_number;
        $customer->customer_flagged = false;
        $customer->bureau_id = $worker_bureau_id;
        $customer->worker_id = $user_id;
        $customer->save();
    }

    /*

    public function get_all_currencies()
    {
        return DB::table('currencies')
            ->join('administrators', 'currencies.admin_id', '=', 'administrators.admin_id')
            ->select('currencies.*', 'administrators.admin_surname', 'administrators.admin_firstname')
            ->get();
    }

    public function get_currency($column_name, $column_value)
    {
        return  DB::table('currencies')->where($column_name, '=', $column_value)->get();
    }

    public function search_for_currencies($where_array, $or_where_array)
    {
        if(count($or_where_array) > 0){
            return  DB::table('currencies')
            ->join('administrators', 'currencies.admin_id', '=', 'administrators.admin_id')
            ->select('currencies.*', 'administrators.admin_surname', 'administrators.admin_firstname')
            ->where($where_array)->orWhere($or_where_array)->get();
        }
        return  DB::table('currencies')
        ->join('administrators', 'currencies.admin_id', '=', 'administrators.admin_id')
        ->select('currencies.*', 'administrators.admin_surname', 'administrators.admin_firstname')
        ->where($where_array)->get();
    }


    public function update_currency($currency_id, $currency_full_name, $currency_abbreviation, $currency_symbol, $currency_flagged, $user_id)
    {
        $currency = Currency::find($currency_id);
        $currency->currency_full_name = $currency_full_name;
        $currency->currency_abbreviation = $currency_abbreviation;
        $currency->currency_symbol = $currency_symbol;
        $currency->currency_flagged = $currency_flagged;
        $currency->admin_id = $user_id;
        $currency->save();
    }
    */
}
