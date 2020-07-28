<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\v1\Rate;
use App\Models\v1\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RateController extends Controller
{
    

    public function make_rate_ext_id($currency_from_abbr, $currency_to_abbr)
    {
        return $currency_from_abbr . "_" . $currency_to_abbr;
    }

    public function add_rate($currency_from_id, $currency_from_abbr, $currency_to_id, $currency_to_abbr, $this_rate, $admin_id)
    {
        $rate = new Rate();
        $rate->rate_ext_id = $this->make_rate_ext_id($currency_from_abbr, $currency_to_abbr);
        $rate->currency_from_id = $currency_from_id;
        $rate->currency_to_id = $currency_to_id;
        $rate->rate = $this_rate;
        $rate->admin_id = $admin_id;
        $rate->save();
    }


    public function get_all_rates($pagination)
    {
        
        $current_rates = DB::table('rates')
            ->join('administrators', 'rates.admin_id', '=', 'administrators.admin_id')
            ->join('currencies', 'rates.currency_from_id', '=', 'currencies.currency_id')
            ->select('rates.*', 'administrators.admin_surname', 'administrators.admin_firstname', 'currencies.currency_full_name')
            ->simplePaginate(20);

        
        for ($i=0; $i < count($current_rates); $i++) { 
            $this_currency = Currency::find($current_rates[$i]->currency_to_id);
            $current_rates[$i]->currency_to_full_name = $this_currency->currency_full_name;
        }

        return $current_rates;
        
    }

    public function update_rate($rate_id, $rate_ext_id, $currency_from_id, $currency_to_id, $this_rate, $admin_id)
    {
        $rate = Rate::find($rate_id);
        $rate->rate_ext_id = $rate_ext_id;
        $rate->currency_from_id = $currency_from_id;
        $rate->currency_to_id = $currency_to_id;
        $rate->rate = $this_rate;
        $rate->admin_id = $admin_id;
        $rate->save();
    }

}
