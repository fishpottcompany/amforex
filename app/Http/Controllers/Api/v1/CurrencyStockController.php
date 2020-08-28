<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\v1\Currency;
use Illuminate\Http\Request;
use App\Models\v1\CurrencyStock;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CurrencyStockController extends Controller
{
    
    public function make_stock_ext_id($currency_abbr, $bureau_id)
    {
        return $bureau_id . "_" . $currency_abbr;
    }

    public function add_currency_stock($currency_id, $currency_abbr, $bureau_id, $this_stock, $worker_id)
    {
        $currency_stock = new CurrencyStock();
        $currency_stock->stock_ext_id = $this->make_stock_ext_id($currency_abbr, $bureau_id);
        $currency_stock->stock = $this_stock;
        $currency_stock->currency_id = $currency_id;
        $currency_stock->bureau_id = $bureau_id;
        $currency_stock->worker_id = $worker_id;
        $currency_stock->save();
    }

    public function update_currency_stock($currency_stock_id, $this_stock, $worker_id)
    {
        $currency_stock = CurrencyStock::find($currency_stock_id);
        $currency_stock->stock = $this_stock;
        $currency_stock->worker_id = $worker_id;
        $currency_stock->save();
    }


    public function get_currency_stock($column_name, $column_value)
    {
        return  DB::table('currency_stocks')->where($column_name, '=', $column_value)->get();
    }


    public function get_currency_stocks($pagination)
    {
        
        $current_stocks = DB::table('currency_stocks')
            ->join('workers', 'currency_stocks.worker_id', '=', 'workers.worker_id')
            ->join('currencies', 'currency_stocks.currency_id', '=', 'currencies.currency_id')
            ->select('currency_stocks.*', 'workers.worker_surname', 'workers.worker_firstname', 'currencies.currency_full_name')
            ->simplePaginate($pagination);


        return $current_stocks;
        
    }

    public function search_for_currency_stocks($pagination, $where_array, $or_where_array)
    {
        
        if(count($or_where_array) > 0){
            $current_stocks = DB::table('currency_stocks')
                ->join('workers', 'currency_stocks.worker_id', '=', 'workers.worker_id')
                ->join('currencies', 'currency_stocks.currency_id', '=', 'currencies.currency_id')
                ->select('currency_stocks.*', 'workers.worker_surname', 'workers.worker_firstname', 'currencies.currency_full_name')
                ->where($where_array)
                ->orWhere($or_where_array)
                ->simplePaginate($pagination);
    
        } else {
            $current_stocks = DB::table('currency_stocks')
            ->join('workers', 'currency_stocks.worker_id', '=', 'workers.worker_id')
            ->join('currencies', 'currency_stocks.currency_id', '=', 'currencies.currency_id')
            ->select('currency_stocks.*', 'workers.worker_surname', 'workers.worker_firstname', 'currencies.currency_full_name')
            ->where($where_array)
            ->simplePaginate($pagination);

        }

        return $current_stocks;
        
    }


}
