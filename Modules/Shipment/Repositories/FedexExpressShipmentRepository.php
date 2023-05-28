<?php

namespace App\Repositories\Shipment;

use App\Interfaces\Shipment\FedexExpressShipmentInterface;
use App\Transaction;
use App\Contact;
use App\Address;
use App\Models\ShipmentSetting;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\TransactionSellLine;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use App\RefNo;
use File;
use DB;
use App\TransactionPayment;

class FedexExpressShipmentRepository implements FedexExpressShipmentInterface
{
    private $baseUrl = "";
    
    private $errors  = [];
    
    private $transColumns = [
        'id',
        'business_id',
        'location_id',
        'status',
        'contact_id',
        'invoice_no',
        'ref_no',
        'transaction_date',
        'shipment_id',
        'service_types',
        'shipping_charges',
        'shipping_status',
        'final_total',
        'fedex_ex_city',
        'address_id',
        'refrance_no',
        'shipmentstatus',
        'fedex_ex_billnumber',
        'additional_notes'
    ];
    
    private $contactColumns = [
        'id',
        'business_id',
        'first_name',
        'last_name',
        'name',
        'email',
        'city',
        'state',
        'country',
        'mobile'
    ];
    
    private $addressColumns = [
        'id',
        'business_id',
        'contact_id',
        'country',
        'city',
        'address',
        'phone',
        'mobile',
        'name',
        'state'
    ];
    
    private $fedexSettingsColumns = [
        'id',
        'business_id',
        'fedex_account',
        'fedex_password',
        'fedex_privatehash',
        'fedex_express_settings'
    ];
    
    private $errorCodes = [-2,-10];
    
    public function __construct()
    {
        $this->baseUrl = config('shipments.fedex-express.baseUrl');
    }
    
   
    
    
    public function cityList()
    {
        try {
            
            $data = [
                "Country" => 'Egypt',
                "Password" => 'FBFk9vOanXw=',
                'UserName' => 'WEBSETest'
            ];
        
            $data = json_encode($data);
            
            $client = new Client(['base_uri' => "https://egxpress.me/EGEXPService.svc/"]);
        
            $response = $client->post('CityList',[
            
                'headers' => ['Content-Type' =>'application/json'],
                'body' => $data
            
            ]);
            
            $responseData = json_decode($response->getBody(),true);
            
            if (! empty($cityListLocations = $responseData['CityListLocation'])) {
                
                return json_encode($cityListLocations);
            }
            
            return [];
            
        } catch(GuzzleException $e) {
            
           if ($e->hasResponse()) {
        
               $exception = (string) $e->getResponse()->getBody();
                $exception = json_decode($exception);
                return new JsonResponse($exception, $e->getCode());
           }
           
           return new JsonResponse($e->getMessage(), 503);
        }

    }
    
    
    public function updateSettings($request,$id)
    {
        try{
            $fedexSettings = $request->input('fedex_express_settings');
            $fedexSettings = json_encode($fedexSettings);
            if($shipmentSetting = ShipmentSetting::find($id)){
                $shipmentSetting->fedex_express_settings = $fedexSettings;
                $shipmentSetting->save();
                $output = [
                    'success' => true,
                    'msg' => __("settings.updated_success"),
                    'url' => url('shipment')
                ];
            }
        } catch(\Exception $e){
            
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __("messages.something_went_wrong"),
                'url' => url('shipment')
            ];
        }
        
         return response()->json($output);
    }
    
    /*
    * this function create new Shipment 
    */
    public function createShipment($id)
    {
        $businessId = session()->get('user.business_id');
        // dd($businessId);
        $fedexSettings = ShipmentSetting::select($this->fedexSettingsColumns)->where('business_id','=',$businessId)->first();
        // dd($fedexSettings);
        $settings = json_decode($fedexSettings->fedex_express_settings,true);
        // dd($settings);
        $order   = $this->getOrderInfo($id);
        // dd($order);
        $contact = $this->getContactInfo($order->contact_id);
        // dd($contact);
        $address = $this->getAddressInfo($order->address_id);
        // dd($address);
        $requestData = $this->prepareOrder($order,$contact,$address,$settings);
        // dd($requestData);
        try{
            
            $client = new Client(['base_uri' => $this->baseUrl]);
            
            $response = $client->post('CreateAirwayBill',[
                'headers' => ['Content-Type' =>'application/json'],
                'body' => json_encode($requestData)
            ]);
            
            $responseData = json_decode($response->getBody(),true);
            // dd($responseData);
            if ($this->isResponseHasError($responseData)) {
                
                $this->errors[] = $responseData['Description'];
                
                return [
                    'status' => false,
                    'errors' => $this->errors
                ];
            }
            
            if($this->isShipmentCreated($responseData)){
                // dd('ok');
                $order->refrance_no = $responseData['AirwayBillNumber'];
                $order->shipmentstatus = 'Fedex/EX - To Be Picked';
                $order->fedex_ex_billnumber = $responseData['AirwayBillNumber'];
                $order->save();
                
                $refOrder = RefNo::where('transaction_id',$order->id)->first();
                // dd($refOrder)    ;
                if(!empty($refOrder)) {
                                          ;
                    $refOrder->ref_no = $responseData['AirwayBillNumber'];
                
                    $refOrder->save();
                                            
                }else {
                    
                    $input =[
                                              
                        'transaction_id'  => $order->id,
                        'order_number'    => $responseData['AirwayBillNumber'],
                        'ref_no'          => $responseData['AirwayBillNumber'],
                    ];
                                            
                    RefNo::create($input);
                                            
                }
                
                
            }
            
            
            // return 'ok';
            
        } catch(GuzzleException $e) {
            $exception = (string) $e->getResponse()->getBody();
            dd($exception);
            $exception = json_decode($exception);
            return $exception;
            dd(json_decode($e->getResponse()->getBody(),true));
        }
        
        
    }
    
    
    /*
    * this function getContactInfo
    * @param $contactId
    */
    private function getContactInfo($contactId)
    {
        return $contactId ? Contact::where('id',$contactId)->select($this->contactColumns)->first() : null;
    
    }
    
    /*
    * this function getAddressInfo
    * @param $addressId
    */
    public function getAddressInfo($addressId)
    {
        return $addressId ? Address::where('id',$addressId)->select($this->addressColumns)->first() : null;
    }
    
    /*
    * this function getOrderInfo
    */
    private function getOrderInfo($transactionId)
    {
        return $transactionId ? Transaction::select($this->transColumns)->find($transactionId) : null;
    }
    
    /*
    * this function prepare order date befour send to Fedex api
    */
    private function prepareOrder($orderInfo,$contactInfo,$addressInfo,$settings)
    {
        $businessName = session()->get('business.name');
        $businessId   = session()->get('business.id');
        $description  = '';
        $description  = ! empty($orderInfo->additional_notes) ? $orderInfo->additional_notes : $settings['SpecialInstruction'];
        $total_paid_up = (float) $this->getOrderPayments($orderInfo->id);
        $final_total  = (float) $orderInfo->final_total;
        
        if( $total_paid_up >= $final_total){
            $final_total = 0;
        } else {
            $final_total -= $total_paid_up;
        }
        return [
            'AccountNo' => $settings['accountnumber'],
            'AirwayBillData' => [
                'Origin' => $settings['SendersCity'],  // required
                'Destination' => $orderInfo->fedex_ex_city, // required
                'ProductType' => "FRE",  // required
		        "ReceiversAddress2" => $addressInfo->country . ' - ' . $addressInfo->city . ' - ' . $addressInfo->address,  // required
		        "ReceiversCompany" => $contactInfo->name,  //requried
		        "SendersAddress1" => $settings['SendersAddress1'],  // requried
		        "SendersAddress2" => $settings['SendersAddress2'],    // required
		      //  "SendersCompany" => ! empty($businessName) ? $businessName : 'Vowalaaa',  // required
		      "SendersCompany" => $businessName, //$this->getBusinessFullName($businessId),
		        "SendersContactPerson" => $businessName, //! empty($businessName) ? $businessName : 'Vowalaaa',  // required  //name of business
		        "SendersMobile" => $settings['phone'],
		        "SendersPhone"  => $settings['phone'],
		      //  "ServiceType" => "COD", // required
		        "ServiceType" => $final_total == 0 ? 'FRG' : 'COD', // required
		        "Weight" => 1,  // requried
		      //  'AirWayBillCreatedBy' => ! empty($businessName) ? $businessName : '',
                // 'CODAmount' => $orderInfo->final_total, //! empty($this->getTransactionQuantity($orderInfo->id)) ? $this->getTransactionQuantity($orderInfo->id) : 1,
                'CODAmount' => $final_total,
                'SendersCountry' => "Egypt",    // تاجر
                "ReceiversCountry" => "Egypt",  // customer
		        "ShipmentInvoiceCurrency" => "EGP",
		      //  "ShipmentInvoiceValue" => $orderInfo->final_total,
		        "ShipmentInvoiceValue" => $final_total,
		        "ShipperReference" => $orderInfo->invoice_no,
		        'NumberofPeices'  => ! empty($this->getTransactionQuantity($orderInfo->id)) ? $this->getTransactionQuantity($orderInfo->id) : 1,
		        "SpecialInstruction" => $description,
		        'SendersCity' => $this->getCityName($settings['SendersCity'])->CityName,
		        'ReceiversEmail' => ! empty($contactInfo->email) ? $contactInfo->email : '',
		        "ReceiversMobile" => ! empty($addressInfo->mobile) ? $addressInfo->mobile : '',
		      //  "ReceiversPhone" => $addressInfo->mobile,
                "GoodsDescription" => $settings['GoodsDescription']
            ],
            'Country' => $settings['SendersCountry'],
            'Password' => $settings['password'],
            'UserName' => $settings['username']
        ];
        
        
        
    }
    
    /*
    * this function check if response Data has error
    */
    public function isResponseHasError(& $response)
    {
        return ( empty($response['AirwayBillNumber']) && in_array($response['Code'],$this->errorCodes) ) ? true : false;
    }
    
    /*
    * this function return error message
    */public function getAllErrorMessage()
    {
        return [
            'ServiceType' => 'Invalid Service Type required',
            'ProductType' => 'Invalid Product Type requried',
            'Weight' => 'Invalid Weight required',
            'shipper' => 'Invalid Shipper Company required',
            'Destination' => 'Invalid Destination Code required',
            'Origin' => 'Invalid Origin Code required',
            'SendersCompany' => 'Invalid Shipper Company',
            "SendersContactPerson" => "Error : Object reference not set to an instance of an object.",  // -10
            'SendersAddress2' => 'Error : Object reference not set to an instance of an object.',        // -10,
            'SendersAddress1' => 'Error : Object reference not set to an instance of an object.' ,       // -10,
            'ReceiversCompany' => 'Error : Object reference not set to an instance of an object.',  // -10
            'ReceiversAddress2' => 'Error : Object reference not set to an instance of an object.',  // -10
        ];
    }
    
    
    private function getTransactionQuantity($transactionId)
    {
        return (int) TransactionSellLine::where('transaction_id',$transactionId)->sum('quantity');
    }
    
    private function isShipmentCreated(& $response)
    {
        if(! empty($response['AirwayBillNumber']) && $response['Code'] == 1 && $response['Description'] == 'Success')
            
            return true;
        else 
            return false;
    }
    
    public function getFedexOrderPdf($shipmentId)
    {
        if (File::exists(public_path('/uploads/fedex_ex/'.$shipmentId.'.pdf'))){
            return response()->download(public_path('/uploads/fedex_ex/'.$shipmentId.'.pdf'));
        }
        
        // dd('ok');
        $order = $this->getOrderInfo($shipmentId);
        // dd($order);
        $businessId = session()->get('user.business_id');
        // dd($businessId);
        $fedexSettings = ShipmentSetting::select($this->fedexSettingsColumns)->where('business_id','=',$businessId)->first();
        // return $fedexSettings;
        $settings = json_decode($fedexSettings->fedex_express_settings,true);
        // dd('ok');
        $client = new Client(['base_uri' => $this->baseUrl]);
        // dd('ok');
        $requestData = [
            "AirwayBillNumber" => $order->fedex_ex_billnumber,
	        "Country" => "Egypt",
	        "RequestUser" => "Mostafa",
            "AccountNo" => $settings['accountnumber'],
	        "Password" => $settings['password'],
	        "UserName" => $settings['username']
        ];
        $response = $client->post('AirwayBillPDFFormat',[
            
            'headers' => ['Content-Type' =>'application/json'],
            'body' => json_encode($requestData)
        ]);
        
        $responseData = json_decode($response->getBody()->getContents());
        
        $AwbBostaPDF       = base64_decode($responseData->ReportDoc);
        
        File::put(public_path('/uploads/fedex_ex/'. $shipmentId . '.pdf'),$AwbBostaPDF);
        
        return response()->download(public_path('/uploads/fedex_ex/'.$shipmentId.'.pdf'));
    }
   
    private function getCityName($cityCode)
    {
        
        $cityList = json_decode($this->cityList());
    
        foreach($cityList as $city) {
            if( $city->CityCode == $cityCode) {
                return $city;
            }
        }
        
        return null;
        
    }
    
    
    private function getBusinessFullName($businessId)
    {
        
        $business = DB::table('business')->select('id','name','owner_id')->where('id','=',$businessId)->first();
        // dd($business);
        $user     = DB::table('users')->select('first_name','last_name')->where('id','=',$business->owner_id)->first();
        
        return $user->first_name . ' ' . $user->last_name . ' -' . $business->name;
    }
    
    /*
            
    //     $data = [];
    //     $data['AccountNo'] = $settings['accountnumber'];
    //     $data['AirwayBillData'] = [
            
    //         'Origin'       => $settings['SendersCity'],
    //         'Destination'  => $orderInfo->fedex_ex_city,
    //         'ProductType' => "FRE",
    //         "ReceiversAddress2" => $addressInfo->country . ' - ' . $addressInfo->city . ' - ' . $addressInfo->address,
    //         "ReceiversCompany" => $contactInfo->name,
    //         "SendersAddress1" => $settings['SendersAddress1'], 
		  //  "SendersAddress2" => $settings['SendersAddress2'], 
		  //  "SendersCompany" => $this->getBusinessFullName($businessId),
		  //  "SendersContactPerson" => ! empty($businessName) ? $businessName : 'Vowalaaa',
		  //  "ServiceType" => "COD",
		  //  "Weight" => 6,
		  //  'CODAmount' => $orderInfo->final_total,
    //         'SendersCountry' => "Egypt",
    //         "ReceiversCountry" => "Egypt",  // customer
		  //  "ShipmentInvoiceCurrency" => "EGP",
		  //  "ShipmentInvoiceValue" => $orderInfo->final_total,
		  //  "ShipperReference" => $orderInfo->id,
		  //  'NumberofPeices'  => ! empty($this->getTransactionQuantity($orderInfo->id)) ? $this->getTransactionQuantity($orderInfo->id) : 1,
		  //  "SpecialInstruction" => $description,
		  //  'SendersCity' => $this->getCityName($settings['SendersCity'])->CityName,
    //     ];
        
        
    //     if (! empty($contactInfo->email)) {
    //         $data['ReceiversEmail'] = $contactInfo->email;
    //     } 
        
    //     if (! empty($addressInfo->mobile)) {
    //         $data['ReceiversMobile'] = $addressInfo->mobile;
    //     }
    //     return $data;
    */
     /*
    Weight  
    */
    /*
    // 'AirWayBillCreatedBy' => 'Mostafa Zayed',  not required
                // 'CODAmount' => 8,  // not required
                // 'CODCurrency' => "EGP",  // not required
                
                // "DutyConsigneePay" => 0,  // not required
                // "GoodsDescription" => "Mobile Accessories",  // not required
                // 'NumberofPeices' => 1,  // not required
                
                // "ReceiversAddress1" => "2end-naser street",  // not required
                
                //  "ReceiversCity" => "Alexandria",  // not
                
                //  "ReceiversContactPerson" => "Ahmed",  // not
		      //  "ReceiversCountry" => "Egypt",  // not
		      //  "ReceiversEmail" => "it@egexpress.eg",  // not
		      //  "ReceiversGeoLocation" => "",   // not 
		      //  "ReceiversMobile" => "01273445799",   // not
		      //  "ReceiversPhone" => "01273445799",   // not
		      //  "ReceiversPinCode" => "",  // not
		      //  "ReceiversProvince" => "",   // not
		      //  "ReceiversSubCity" => "",   // not 
		      //  "SendersCountry" => "Egypt",
		      //  "SendersEmail" => "itm@egyptepxress.eg",
		      //  "SendersGeoLocation" => "",  // not
		      //  "SendersMobile" => "01029811233", // not
		      //  "SendersPhone" => "01029811233", // not 
		      //  "SendersPinCode" => "", // not
		      //  "SendersSubCity" => "", /// not
		      //  "SendersCity" => "Helipolis",   // not 
		       "ShipmentDimension" => "",  // not required
		        "ShipmentInvoiceCurrency" => "EGP", // not requried
		        "ShipmentInvoiceValue" => 500, // not requried
		        "ShipperReference" => "JD123444",  // not required
		        "ShipperVatAccount" => "",      // not requried
		        "SpecialInstruction" => "Confirm Location before Delivery",  //not requried
    */
    
    /*
        "AirWayBillCreatedBy":"Mostafa Zayed",
		"CODAmount":8,
		"CODCurrency":"EGP",
		"Destination":"SHO",
		"DutyConsigneePay":0,
		"GoodsDescription":"Mobile Accessories",
		"NumberofPeices":1,
		"Origin":"CAI",
		"ProductType":"FRE",
		"ReceiversAddress1":"2end-naser street",
		"ReceiversAddress2":"2pices - ales street",
		"ReceiversCity":"Alexandria",
		"ReceiversCompany":"Egypt Expresss",
		"ReceiversContactPerson":"Ahmed",
		"ReceiversCountry":"Egypt",
		"ReceiversEmail":"it@egexpress.eg",
		"ReceiversGeoLocation":"",
		"ReceiversMobile":"01273445799",
		"ReceiversPhone":"01273445799",
		"ReceiversPinCode":"",
		"ReceiversProvince":"",
		"ReceiversSubCity":"",
		"SendersAddress1":"Masaken Street",
		"SendersAddress2":"Helipolis",
		"SendersCity":"Helipolis",
		"SendersCompany":"Egypt Express",
		"SendersContactPerson":"Mr.Amin",
		"SendersCountry":"Egypt",
		"SendersEmail":"itm@egyptepxress.eg",
		"SendersGeoLocation":"",
		"SendersMobile":"01029811233",
		"SendersPhone":"01029811233",
		"SendersPinCode":"",
		"SendersSubCity":"",
		"ServiceType":"FRG",
		"ShipmentDimension":"",
		"ShipmentInvoiceCurrency":"EGP",
		"ShipmentInvoiceValue":500,
		"ShipperReference":"JD123444",
		"ShipperVatAccount":"",
		"SpecialInstruction":"Confirm Location before Delivery",
		"Weight":6
        */
        
    private function getOrderPayments($transactionId)    
    {
        $payments = TransactionPayment::where('transaction_id',$transactionId)->select('is_return','amount')->get();
        
        $totalPaid = 0;
        
        $totalReturned = 0;
        
        if($payments->count() > 0) {
            
            foreach($payments as $payment) {
               
                if ($payment->is_return == 1) {
                
                    $totalReturned += $payment->amount;
                    
                } else {
                    
                    $totalPaid += $payment->amount;
                }
        
            } 
            
            return $totalPaid - $totalReturned;
        }
        
        return 0;
    }
    
}