<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\v1\Rate;
use Illuminate\Http\Request;

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


    public function get_all_rates()
    {
        return DB::table('rates')
            ->join('administrators', 'rates.admin_id', '=', 'administrators.admin_id')
            ->join('currencies', 'rates.currency_from_id', '=', 'currencies.currency_id')
            ->join('currencies', 'rates.currency_to_id', '=', 'currencies.currency_id')
            ->select('rates.*', 'administrators.admin_surname', 'administrators.admin_firstname')
            ->get();
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
