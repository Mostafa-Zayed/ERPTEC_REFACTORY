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

class TransactionPaymentRepository
{
    
    public function getById($transaction_payment_id)
    {
        return DB::table('transaction_payments')->find($transaction_payment_id);
    }
    
    
    public function getTotalAmount($tansaction_id)
    {
        return DB::table('transaction_payments')->where('transaction_id','=',$tansaction_id)->sum('amount');
    }
}