<?php

namespace App\Http\Controllers;

use App\Account;
use App\AccountTransaction;
use App\AccountType;
use App\TransactionPayment;
use App\Utils\Util;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\Facades\DataTables;
use App\Media;
use Illuminate\Pipeline\Pipeline;

class PipeLineController extends Controller
{
    // public function __invoke()
    // {
    //     $number = app(Pipeline::class)
    //                 ->send(5)
    //                 ->through([
                        
    //                 ]);
        
    // }
}