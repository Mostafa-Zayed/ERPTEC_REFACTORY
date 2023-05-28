<?php

namespace Modules\Shipment\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ConsumesExternalServices;
use App\Transaction;
use Modules\Shipment\Interfaces\VooShipmentInterface;
use App\Contact;
use App\Address;

class VooShipmentController extends Controller
{
    private $vooInterface;
    
    public function __construct(VooShipmentInterface $vooInterface ,Transaction $transaction)
    {
        $this->vooInterface = $vooInterface;
    }
    
    public function index()
    {
        
        // return $this->vooInterface->index();
    }
    
    public function shipmentOrder($id = null)
    {
        $order = Transaction::find(217);
        
        $shipmentAccount = $order->shipmentAccount;
        
        // check if account active
        $settings = $shipmentAccount->settings;
        
        // get contact info
        $contactInfo = Contact::where('id',$order->contact_id)->get();
        
        // get address info
        // $addressInfo = Address::where('id',$order->address_id)->get();
        
        return $this->vooInterface->getAreas();
        return $contactInfo;
        return $shipmentAccount->shipmentCompany;
        return $order;
        // get order
        // get account 
        // get company
    }
}