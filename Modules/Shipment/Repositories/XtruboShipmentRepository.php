<?php

namespace App\Repositories\Shipment;

use App\Interfaces\Shipment\XtruboShipmentInterface;
use App\Transaction;
use App\Contact;
use App\Address;
use App\Models\ShipmentSetting;
use GuzzleHttp\Exception\GuzzleException;
 
use App\TransactionSellLine;
use App\RefNo;
use Illuminate\Support\Facades\DB;
use File;
class XtruboShipmentRepository implements XtruboShipmentInterface
{
    private $url = 'https://portal.xturbox.com/api/v1/client/';
    private $token;
    private $tokenType = '';
    private $transaction;
    private $errorMessages = [];
    
    public function __construct(Transaction  $transaction)
    {
        $this->transaction = $transaction;
        
    }
    
    
    public function makeRequest($id)
    {
        // return $id;
        $businessId = session()->get('user.business_id');
        $xturboSettings = ShipmentSetting::select('xturbo_settings')->where('business_id','=',$businessId)->first();
        $xturbos = json_decode($xturboSettings->xturbo_settings,true);
        // return $xturbos['pickupCity'];
        //'xturbo_deliver_city'
        //xturbo_packaging
        $order = $this->transaction->select(['id','shipping_details','contact_id','address_id','xturbo_zone','final_total','order_id','xturbo_details'])->find($id);
        $orderDetails = json_decode($order->xturbo_details,true);
        // return $orderDetails;
        // return (int) $orderDetails['fragile'];
        // return json_decode($order->xturbo_details);
        $totalQuntitiy = TransactionSellLine::where('transaction_id',$id)->sum('quantity');
        $totalQuntitiy = (int) $totalQuntitiy;
        $contact = Contact::where('id',$order->contact_id)->select(['id','name','mobile'])->first();
        $address = Address::where('id',$order->address_id)->select(['city','address','country'])->first();
        $note = ! empty($order->shipping_details) ? $order->shipping_details : 'Notes Not Exists';
        $contactAddress = "{$address->country} , {$address->city} , {$address->address}";
        $deliverAddress = ! empty($orderDetails['deliverAddress']) ? $orderDetails['deliverAddress'] : $contactAddress;
        
        $orderData = json_encode([
            'pickupAddress' => $xturbos['pickupAddress'],
            'receiverName' => $contact->name,
            'receiverPhone' => (int) $contact->mobile,
            'deliverAddress' => $contactAddress,
            'weight' => !empty($orderDetails['weight']) ? (int) $orderDetails : 0,
            'length' => ! empty($orderDetails['length']) ? (float) $orderDetails['length'] : 0.0,
            'width' => ! empty($orderDetails['width']) ? (float) $orderDetails['width'] : 0.0,
            'height' => ! empty($orderDetails['height']) ? (float) $orderDetails['height'] : 0.0,
            'payment_type' => 'COD',
            'pickupCity' => $xturbos['pickupCity'],
            'deliverCity' => $orderDetails['deliverCity'],
            'fragile' => ! empty($orderDetails['fragile']) ? 1 : 0,
            'packaging' => $orderDetails['packaging'],
            'cod' => (int) $order->final_total,
            'quantity' => $totalQuntitiy,
            'note' => $note,
            
            ]);
        // return $orderData;
        $this->login();
        // return 'ok';
        if(empty($this->errorMessages) && ! empty($this->token)) {
            
            $client = new Client(['base_uri' => $this->url]);
            
            try{
                $response = $client->post('createOrder',[
                    'headers' => ['Content-Type' => 'application/json' , 'Authorization'=> "Bearer {$this->token}"],
                    'body' => $orderData
                    ]
                );
                
                
                $responseData = json_decode($response->getBody()->getContents(),true);
                if (isset($responseData['error'])){
                    $this->errorMessages = $responseData['error'];
                    // return $this->errorMessages;
                    return $responseData;
                } elseif($responseData['success']){
                    $orderDetails['member'] = $responseData['order']['member'];
                    $orderDetails['orderType'] = $responseData['order']['orderType'];
                    $oreerDetails['trackType'] = $responseData['order']['trackType'];
                    $orderDetails['storeId']  = $responseData['order']['storeId'];
                    $orderDetails['payment_type'] = $responseData['order']['payment_type'];
                    $orderDetails = json_encode($orderDetails,true);
                    $order->xturbo_details = $orderDetails;
                    $order->shipmentstatus = 'XTURBO/API - To Be Picked';
                    $order->refrance_no = $responseData['order']['id'];
                    $order->xturbo_shipment = $responseData['order']['id'];
                    $order->save();
                    
                    $refOrder = RefNo::where('transaction_id',$order->id)->first();
                    
                    if(!empty($refOrder)) {
                                               
                        $refOrder->ref_no = $responseData['order']['id'];
                
                        $refOrder->save();
                                            
                    }else {
            
                        $input =[
                                              
                            'transaction_id'  => $order->id,
                            'order_number'    => $responseData['order']['id'],
                            'ref_no'          => $responseData['order']['id'],
                        ];
                                            
                        RefNo::create($input);
                                            
                    }
                    
                    
                }
                
            } catch(GuzzleException $e){
                $response = $e->getResponse();
                
                return gettype($response->getBody()->getContents());
                return json_decode($response->getBody(),true);   
            }
        }
    }
    
    public function getCities()
    {
        $this->login();
        
        if (empty($this->errorMessages) && !empty($this->token)){
            
            $client = new Client(['base_uri' => $this->url]);
            
            try{
                
                $response = $client->get('cities',[
                    'headers' => ['Content-Type' => 'application/json' , 'Authorization'=> "Bearer {$this->token}"],
                    ]
                );
                return json_decode($response->getBody()->getContents());
                dd($response->getBody(),true);
                return json_decode($response->getBody(),true);
                
            }catch(GuzzleException $e){
                $response = $e->getResponse();
                return json_decode($response->getBody(),true);
            }    
        }
        
        return $this->errorMessages;
    }
    
    public function prepareOrder($id)
    {
        return 'xtrubo prepared order';
    }
    
    private function login()
    {
        $businessId = session()->get('user.business_id');
        $credentials = ShipmentSetting::select('xturbo_password','xturbo_email')->where('business_id','=',$businessId)->first();
        $data = [
                'email' => $credentials->xturbo_email,
                'password' => $credentials->xturbo_password
            ];
            
        $data = json_encode($data);
        
        $client = new Client(['base_uri' => $this->url]);
        try{
            $response = $client->post('login',[
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $data
                ]
            );
            $finalResponse = json_decode($response->getBody(),true); //->getContents();
            if ($finalResponse['success']){
                $this->token = $finalResponse['token'];
                return true;
            }
            return false;
        }catch(GuzzleException $e){
            $response = $e->getResponse();
            $finalResponse = json_decode($response->getBody(),true); //->getContents();
            // return $finalResponse;
            if ($finalResponse['success']){
                return true;
            } else {
                $this->errorMessages[] = $finalResponse['message'];
                return false;
            }
        }
    }
    
    public function getShipmentOrderPdf($shipmentId)
    {
        if (File::exists(public_path('/uploads/Xturbo/'.$shipmentId.'.pdf'))){
            return response()->download(public_path('/uploads/Xturbo/'.$shipmentId.'.pdf'));
        }
        
        $this->login();
        if(empty($this->errorMessages) && ! empty($this->token)) {
           $client = new Client(['base_uri' => $this->url]);
           try{
                $response = $client->get('printWaybill2/'.$shipmentId,[
                    'headers' => ['Content-Type' => 'application/json' ,
                    'Accept' => 'application/pdf',
                    'Authorization'=> "Bearer {$this->token}"]
                    ]
                    
                );
                File::put(public_path('/uploads/Xturbo/'.$shipmentId.'.pdf'),$response->getBody()->getContents());
                return response()->download(public_path('/uploads/Xturbo/'.$shipmentId.'.pdf'));
           } catch(GuzzleException $e){
                $response = $e->getResponse();
                
                return gettype($response->getBody()->getContents());
                return json_decode($response->getBody(),true);   
            }
       }
    }
}