<?php

namespace Modules\Shipment\Repositories;

use Modules\Shipment\Interfaces\VooShipmentInterface;
use App\Transaction;
use App\Contact;
use App\Address;
use App\Models\ShipmentSetting;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\RefNo;
use App\Traits\ConsumesExternalServices;

class VooShipmentRepository implements VooShipmentInterface
{
    private $url = 'https://my.getvoo.com/api/';
    private $token;
    private $transaction;
    private $baseUrl;
    private $errors = [];
    private $guzzleExceptions = [];
    use ConsumesExternalServices;
    
    public function __construct()
    {
        $this->baseUrl = config('shipments.companies.voo.baseUrl');
    }
    
    public function index()
    {
        $businessId = session()->get('user.business_id');
        return $this->vooInterface->index();
    }
    
    public function getAreas()
    {
        return $this->makeRequest('GET','areas');
    }
    
    public function resolveAuthorization(&$queryParams, &$formParams, &$headers)
    {
        $accessToken = $this->resolveAccessToken();
        $headers['Content-Type']  ='application/json';
        $headers['Accept']        = 'application/json';
        $headers['Authorization'] = $accessToken;
    }
    
    private function resolveAccessToken()
    {
        return config('shipments.companies.voo.token');
    }
    
    public function decodeResponse($response)
    {
        $decodedResponse = json_decode($response,true);
        return $decodedResponse->data ?? $decodedResponse;
    }
    
    public function checkIfErrorResponse($response)
    {
        if(isset($response->error)){
            throw new \Exception('error');
        }
    }
    // public function makeRequest($id)
    // {
        
    //     $token =  $this->getVooCustomerToken();
        
    //     $order = $this->transaction->select(['id','shipping_details','additional_notes','contact_id','address_id','voo_zone','final_total','voo_courier','order_id','voo_order'])->find($id);
        
    //     $contact = Contact::where('id',$order->contact_id)->select(['id','name','mobile'])->first();
        
        
    //     $address = Address::where('id',$order->address_id)->select(['city','address','country'])->first();
        
    //     $shipmentArea = $this->isAreaExists($order->voo_zone);
        
    //     // $shipmentArea = $this->isAreaExists($order->voo_zone) ?  : 'no area founded';
    //     // return $shipmentArea;
    //     $note = ! empty($order->additional_notes) ? $order->additional_notes : 'Notes Not Exists';
        
    //     // $contactAddress = $address->country. ', '.$address->city;
    //     $contactAddress = "{$address->country} , {$address->city} , {$address->address}";
    //     // $contactAddress = $address->country. ', '.$address->city;
        
    //     $client = new Client(['base_uri' => "https://my.getvoo.com/api/"]);
        
    //     $code  = rand(7642876,99999999999);
    //     $shipment_code = "vow{$code}";
    //     // return $shipment_code;
    //     // return 'zayed';
    //     $data = [
    //         // "shipment_code" => (string) !empty($order->id) ? "$code" : "5555555",
    //         "shipment_code" => "$shipment_code",
    //         "name" => "{$contact->name}",
    //         "phone" => "$contact->mobile",
    //         "area_id" => "$shipmentArea",
    //         "address" => "{$contactAddress}",
    //         "item_description" => "item description",
    //         "total_cash_collection" => "{$order->final_total}",
    //         "zero_cash_collection" => 0,
    //         "landmark" => "{$address->city}",
    //         "notes" => "$note",
    //         "courier" => "$order->voo_courier",
    //         'isVowalaa' => 1,
    //         'vowalaa_id' => rand(100000,9999999)
    //         ];
        
    //     $data = json_encode($data);
    //     // return $data;
    //     $response = $client->post('orders',[
    //      'headers' => ['Content-Type' => 'application/json' , 'Authorization'=> "Bearer {$token}"],
    //      'body' => $data
    //      ]
    //     );
        
    //     $finalResponse = json_decode($response->getBody(),true);
    //     // dd($finalResponse);
    //     if ($this->isOrderRegister($finalResponse)){
        
    //         $order->shipmentstatus = 'Voo/Api - To Be Picked';
    //         // $order->refrance_no = $finalResponse['data']['tracking_code'];
    //         $order->refrance_no = $finalResponse['data'];
    //         // $order->order_id = $finalResponse['data']['order_id'];
    //         // $order->voo_order = $finalResponse['data']['order_id'];
    //         $order->voo_order   = $finalResponse['data'];
    //         $order->save();
            
    //         $data = RefNo::where('transaction_id',$order->id)->first();
            
    //         if(!empty($data)) {
                                               
    //             // $data->ref_no = $finalResponse['data']['tracking_code'];
    //             $data->ref_no = $finalResponse['data'];
    //             $data->save();
                                            
    //         }else {
            
    //             $input =[
                                              
    //                 'transaction_id'  => $order->id,
    //                 // 'order_number'    => $finalResponse['data']['order_id'],
    //                 // 'ref_no'          => $finalResponse['data']['tracking_code'],
    //                 'order_number'    => $finalResponse['data'],
    //                 'ref_no'          => $finalResponse['data'],
    //             ];
                                            
    //             RefNo::create($input);
                                            
    //         }
    //     }
        
        
    // }
    
    
    // public function getOrderInfo($orderId)
    // {
        
    //     $token =  $this->getVooCustomerToken();
        
    //     $client = new Client([
    //         'headers' => [
    //             'Content-Type' =>'application/json',
    //             'Accept'=>'application/json',
    //             'Authorization' => 'Bearer ' . $token, 
                
    //             ]
    //         ]);
    //     // return $this->url;
    //     $response =  json_decode($client->get($this->url.'orders/'.$orderId)->getBody(),true)['data']['order'];
    //     // return $response;
    //     return view('shipments.voo.order',['order' => $response]);
        
    // }
    
    
    
    // public function makeOrder()
    // {
    // //   return 'index from vooo';
    // }

    // public function prepareOrder($transactionId)
    // {
        
    // }
    
    
    
    // public function getAreas()
    // {
    //     $client = new Client([
    //         'headers' => [
    //             'Content-Type' =>'application/json',
    //             'Accept'=>'application/json',
    //             'Authorization' => 'Bearer ' . $this->token, 
                
    //             ]
    //         ]);
            
    //     // return collect(json_decode($client->get($this->url.'areas')->getBody(),true)['data']['areas'])->pluck('name','id')->toArray();
    //     $response = $client->get($this->url.'areas');
    //     $responseData = json_decode($response->getBody(),true);
        
    //     $responseData = (array) $responseData['data']['areas'];
    //     return ! empty($responseData) ? $responseData : [];
    //     // return $responseData = (array) $responseData['data']['areas'];
    //     // foreach($responseData as $new){
    //     //     return $new['id'];
    //     // }
    //     // return $responseData;
    //     // return $responseData['data']['areas'];
    //     // return collect(json_decode($client->get($this->url.'areas')->getBody(),true)['data']['areas'])->pluck('name','id')->toArray();
    // }
    
    
    // private function getVooCustomerToken()
    // {
    //     $business_id = session()->get('user.business_id');
        
    //     $shipmentSetting = ShipmentSetting::where('business_id',$business_id)->select(['voo'])->first();
        
    //     return ! empty($shipmentSetting->voo) ? $shipmentSetting->voo : null;
    // }
    
    // private function isAreaExists($orderArea)
    // {
        
    //     $areas = $this->getAreas();
    //     foreach($areas as $area){
    //         if ($area['id'] == $orderArea){
    //             return $orderArea;
    //         }
            
    //         if ($area['name'] == $orderArea){
    //             return $area['id'];
    //         }
    //     }
        
    //     return false;
    //     // return key_exists($orderArea,$areas);
    // }
    
    
    // // private function getOrderInfo($orderId,$shipmentId)
    // // {
    // //     $order = $this->transaction->find($id);
    // // }

    // private function isOrderRegister(&$response)
    // {
    //     return  isset($response['status']['code']) && $response['status']['code'] == 200 ? true : false;
            
    // }
    
    
    // public function test()
    // {
    //     $client = new Client();
        
    //     try{
            
    //         $response = $client->request('GET',$this->baseUrl . 'areas',
        
    //             [
    //                 'headers' => [
    //                     'Content-Type' => 'application/json'
    //                 ]
    //             ]
    //         );
            
    //         if ($response->getStatusCode() !== 200 && $response->getReasonPhrase !== 'OK'){
                
    //             $this->errors['areas'] = 'Failure to get areas';
                
    //             return $this->errors;
    //         }
            
    //         $responseData = json_decode($response->getBody(),true);
            
    //         return ! empty($responseData['data']['areas']) ? $responseData['data']['areas'] : [];
            
    //     } catch(\GuzzleHttp\Exception\ClientException $exception){
            
    //         $this->guzzleExceptions['areas'] = [
    //             'code' => $exception->getCode(),
    //             'message' => $exception->getMessage()
    //         ];
            
    //         return $this->guzzleExceptions;
    //     }
    // }
    
    // public function get_areas()
    // {
    //     $client = new Client();
        
    //     $response = $client->request('GET',$this->baseUrl . 'areas',
        
    //         [
    //             'headers' => [
    //                 'Content-Type' => 'application/json'
    //             ]
    //         ]
    //     );
        
    //     dd($response);
    // }
    
    // /*
    // *  get all prices of the couriers for the normal local order
    // */
    // public function getLocalPrices($id)
    // {
        
    //     $requestData = json_encode([
    //             "drop_area_id" => $id
    //         ]);
    //   if (! empty($token = $this->getVooCustomerToken())) {
           
    //       try{
               
    //             $client = new Client();
       
    //             $response = $client->request("GET",$this->baseUrl . 'localPrices',
    //                 [
    //                     'headers' => [
    //                         'Content-Type' => 'application/json',
    //                         'Authorization' => 'Bearer' . $token
    //                     ],
                        
    //                     'body' => $requestData
    //                 ]
    //             );
                
    //             $responseData = json_decode($response->getBody(),true);
                
    //             if (empty($responseData['data']) || $responseData['status']['code'] != 200) {
                    
    //                 return $responseData['status'];
    //             }
                
    //             return $responseData['data'];
                
                
    //       } catch(GuzzleException $exception) {
               
    //             return [
    //                 'code' => $exception->getCode(),
    //                 'message' => $exception->getMessage()
    //             ];
    //       }
    //   }
         
    // }
    
    
    // public function getOrderAWB($id)
    // {
        
    //     if (empty($id)) {
    //         $this->errors['order'] = 'Order Id not Found';
    //     }
        
    //     if (empty($token = $this->getVooCustomerToken())) {
    //         $this->errors['token'] = 'Voo Api Token Not Exists';
    //     }
       
    //     if (empty($this->errors)) {
            
    //         try{
                
    //             $client = new Client();
    //             $url = $this->baseUrl . 'printAWB/'. $id;
    //             // dd($token);
    //             // dd($url);
    //             // dd($token);
    //             $response = $client->request('GET',$url,
    //                 [
    //                     'headers' => [
    //                         'Content-Type' => 'application/json',
    //                         'Authorization' => 'Bearer' . $token
    //                     ],
    //                 ]
    //             );
                
    //             echo $response->getBody()->getContents();
    //             dd('ok');
    //             dd(json_decode($response->getBody(),true));
    //         } catch(GuzzleException $exception) {
                
    //             return [
    //                 'type' => 'Guzzle Exception',
    //                 'code'    => $exception->getCode(),
    //                 'message' => $exception->getMessage()
    //             ];
    //         }
    //     }
        
    // }
    
    
    // public function createNormalOrder($transactionId)
    // {
    //     $token =  $this->getVooCustomerToken();
        
    //     if(empty($token)) {
    //         $this->errors['token'] = 'Token Api Not Found';
    //     }
        
    //     $order = $this->transaction->select(['id','shipping_details','additional_notes','contact_id','address_id','voo_zone','final_total','voo_courier','order_id','voo_order'])->find($transactionId);
        
        
    // }
    
}