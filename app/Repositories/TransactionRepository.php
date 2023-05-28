<?php

namespace App\Repositories;

use App\Interfaces\TransactionInterface;
use App\Http\Traits\BusinessService;
use Illuminate\Support\Facades\Config;
use App\Http\Traits\Util;
use App\Utils\ModuleUtil;
use App\Http\Traits\ProductService;
use App\Product;
use App\Media;
use \DB;

class TransactionRepository implements TransactionInterface
{
    
    public function getById($transaction_id)
    {
        return DB::table('transactions')->find($transaction_id);
    }
}