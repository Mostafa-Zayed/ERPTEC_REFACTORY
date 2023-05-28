<?php

namespace App\Repositories;

// use App\Interfaces\SellTransactionInterface;
use App\Http\Traits\BusinessService;
use Illuminate\Support\Facades\Config;
use App\Http\Traits\Util;
use App\Utils\ModuleUtil;
use App\Http\Traits\ProductService;
use App\Product;
use App\Media;
use \DB;

class SellTransactionRepository 
{
    
    public function getByTransctionId($transaction_id)
    {
        return DB::table('transaction_sell_lines')->where('transaction_id','=',$transaction_id)->get();
    }
    
    public function getTransactionTotalQuantity($transaction_id)
    {
        return DB::table('transaction_sell_lines')->where('transaction_id','=',$transaction_id)->sum('quantity');
    }
}