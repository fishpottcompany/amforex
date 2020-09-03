<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\v1\Trade;
use App\Models\v1\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TradeController extends Controller
{

    public function add_trade($trade_currency_in_id, $trade_currency_in_old_stock, $trade_currency_in_new_stock, $trade_currency_in_amount,
     $trade_currency_out_id, $trade_currency_out_old_stock, $trade_currency_out_new_stock, $trade_currency_out_amount,
     $trade_bureau_rate, $trade_bog_rate, $trade_flagged, $customer_id_1_id, $worker_id, $branch_id, $bureau_id)
    {
        $trade = new Trade();
        $trade->trade_currency_in_id = $trade_currency_in_id;
        $trade->trade_currency_in_old_stock = $trade_currency_in_old_stock;
        $trade->trade_currency_in_new_stock = $trade_currency_in_new_stock;
        $trade->trade_currency_in_amount = $trade_currency_in_amount;
        $trade->trade_currency_out_id = $trade_currency_out_id;
        $trade->trade_currency_out_old_stock = $trade_currency_out_old_stock;
        $trade->trade_currency_out_new_stock = $trade_currency_out_new_stock;
        $trade->trade_currency_out_amount = $trade_currency_out_amount;
        $trade->trade_bureau_rate = $trade_bureau_rate;
        $trade->trade_bog_rate = $trade_bog_rate;
        $trade->trade_flagged = $trade_flagged;
        $trade->customer_id_1_id = $customer_id_1_id;
        $trade->worker_id = $worker_id;
        $trade->branch_id = $branch_id;
        $trade->bureau_id = $bureau_id;
        $trade->save();
    }


    public function get_trades($pagination)
    {
        $current_trades = DB::table('trades')
            ->join('workers', 'trades.worker_id', '=', 'workers.worker_id')
            ->join('currencies', 'trades.trade_currency_in_id', '=', 'currencies.currency_id')
            ->join('customers', 'trades.customer_id_1_id', '=', 'customers.customer_id_1_id')
            ->select('trades.*', 'workers.worker_surname', 'workers.worker_firstname', 'currencies.currency_full_name', 'customers.customer_surname', 'customers.customer_firstname')
            ->orderBy('trades.trade_id', 'desc')
            ->simplePaginate($pagination);

        for ($i=0; $i < count($current_trades); $i++) { 
            $this_currency = Currency::find($current_trades[$i]->trade_currency_out_id);
            $current_trades[$i]->trade_currency_out_full_name = $this_currency->currency_full_name;
        }
        
        return $current_trades;
        
    }


    public function search_for_trades($pagination, $where_array, $or_where_array)
    {
        $current_trades = null;

        if(count($where_array) > 0){
            $current_trades = DB::table('trades')
                ->join('workers', 'trades.worker_id', '=', 'workers.worker_id')
                ->join('currencies', 'trades.trade_currency_in_id', '=', 'currencies.currency_id')
                ->join('customers', 'trades.customer_id_1_id', '=', 'customers.customer_id_1_id')
                ->select('trades.*', 'workers.worker_surname', 'workers.worker_firstname', 'currencies.currency_full_name', 'customers.customer_surname', 'customers.customer_firstname')
                ->where($where_array)
                ->orWhere($or_where_array)
                ->orderBy('trades.trade_id', 'desc')
                ->simplePaginate($pagination);

                for ($i=0; $i < count($current_trades); $i++) { 
                    $this_currency = Currency::find($current_trades[$i]->trade_currency_out_id);
                    $current_trades[$i]->trade_currency_out_full_name = $this_currency->currency_full_name;
                }
                
            /*
            $current_trades = DB::table('trades')
                ->join('workers', 'trades.worker_id', '=', 'workers.worker_id')
                ->join('currencies', 'trades.trade_currency_in_id', '=', 'currencies.currency_id')
                ->join('customers', 'trades.customer_id_1_id', '=', 'customers.customer_id_1_id')
                ->select('trades.*', 'workers.worker_surname', 'workers.worker_firstname', 'currencies.currency_full_name', 'customers.customer_surname', 'customers.customer_firstname')
                ->where(array())
                ->orderBy('trades.trade_id', 'desc')
                ->simplePaginate($pagination);
            
            */
        }

        return $current_trades;
        
    }



}
