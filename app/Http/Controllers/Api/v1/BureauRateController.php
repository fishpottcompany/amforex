<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\v1\Currency;
use Illuminate\Http\Request;
use App\Models\v1\BureauRate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BureauRateController extends Controller
{
    
    public function make_rate_ext_id($bureau_id, $currency_from_abbr, $currency_to_abbr)
    {
        return $bureau_id . "_" . $currency_from_abbr . "_" . $currency_to_abbr;
    }

    public function add_rate($bureau_id, $currency_from_id, $currency_from_abbr, $currency_to_id, $currency_to_abbr, $this_rate, $worker_id)
    {
        $rate = new BureauRate();
        $rate->bureau_rate_ext_id = $this->make_rate_ext_id($bureau_id, $currency_from_abbr, $currency_to_abbr);
        $rate->currency_from_id = $currency_from_id;
        $rate->currency_to_id = $currency_to_id;
        $rate->rate = $this_rate;
        $rate->worker_id = $worker_id;
        $rate->bureau_id = $bureau_id;
        $rate->save();
    }



    public function update_rate($bureau_id, $rate_id, $rate_ext_id, $currency_from_id, $currency_to_id, $this_rate, $worker_id)
    {
        $rate = BureauRate::find($rate_id);
        $rate->bureau_rate_ext_id = $rate_ext_id;
        $rate->currency_from_id = $currency_from_id;
        $rate->currency_to_id = $currency_to_id;
        $rate->rate = $this_rate;
        $rate->worker_id = $worker_id;
        $rate->bureau_id = $bureau_id;
        $rate->save();
    }



    public function get_all_rates($pagination)
    {
        
        $current_rates = DB::table('bureau_rates')
            ->join('workers', 'bureau_rates.worker_id', '=', 'workers.worker_id')
            ->join('currencies', 'bureau_rates.currency_from_id', '=', 'currencies.currency_id')
            ->select('bureau_rates.*', 'workers.worker_surname', 'workers.worker_firstname', 'currencies.currency_full_name')
            ->simplePaginate($pagination);

        
        for ($i=0; $i < count($current_rates); $i++) { 
            $this_currency = Currency::find($current_rates[$i]->currency_to_id);
            $current_rates[$i]->currency_to_full_name = $this_currency->currency_full_name;
        }

        return $current_rates;
        
    }

    public function search_for_rates($pagination, $where_array, $or_where_array)
    {
        
        if(count($or_where_array) > 0){
            $current_rates = DB::table('bureau_rates')
                ->join('workers', 'bureau_rates.worker_id', '=', 'workers.worker_id')
                ->join('currencies', 'bureau_rates.currency_from_id', '=', 'currencies.currency_id')
                ->select('bureau_rates.*', 'workers.worker_surname', 'workers.worker_firstname', 'currencies.currency_full_name')
                ->where($where_array)
                ->orWhere($or_where_array)
                ->simplePaginate($pagination);
    
        } else {
            $current_rates = DB::table('bureau_rates')
            ->join('workers', 'bureau_rates.worker_id', '=', 'workers.worker_id')
            ->join('currencies', 'bureau_rates.currency_from_id', '=', 'currencies.currency_id')
            ->select('bureau_rates.*', 'workers.worker_surname', 'workers.worker_firstname', 'currencies.currency_full_name')
            ->where($where_array)
            ->simplePaginate($pagination);

        }

        
        for ($i=0; $i < count($current_rates); $i++) { 
            $this_currency = Currency::find($current_rates[$i]->currency_to_id);
            $current_rates[$i]->currency_to_full_name = $this_currency->currency_full_name;
        }

        return $current_rates;
        
    }


}
