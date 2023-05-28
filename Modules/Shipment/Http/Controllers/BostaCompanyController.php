<?php

namespace Modules\Shipment\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Shipment\Services\BostaService;
use App\Repositories\TransactionRepository;
use App\Repositories\SellTransactionRepository;

class BostaCompanyController extends Controller
{
    private static $BOSTA_URL_SYNC = 'https://erptec.net/erp/shipment/bosta/sync';
    

    public function __construct(TransactionRepository $transactionRepository,SellTransactionRepository $sellTransactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->sellTransactionRepository = $sellTransactionRepository;
    }
    public function index()
    {
        $service = new XturboService();
        dd($service::$BASE_URL);
        return 'index';
    }
    
    public function getCitites()
    {
        dd('cities');
    }
    
    public function getZones()
    {
        dd('zones');
    }
    
    public function deliveries($id = 147)
    {
        dd($this->sellTransactionRepository->getTransactionTotalQuantity($id));
        dd($this->transactionRepository->getById($id));
    }
    
    public static function prepareBostaOrder(&$order)
    {   
        return [
            'type' => 10,
            'cod' => $order->final_total,
            'webhookUrl' => self::$$BOSTA_URL_SYNC,
        ];
         
    }
    
    public function sync()
    {
        return 'sync';
    }
}