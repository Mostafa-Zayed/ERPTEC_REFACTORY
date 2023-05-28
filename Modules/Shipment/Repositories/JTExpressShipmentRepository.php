<?php

namespace App\Repositories\Shipment;

use App\Interfaces\Shipment\JTExpressShipmentInterface;
use App\Models\ShipmentSetting;
use App\Transaction;
use App\Contact;
use App\Address;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\RefNo;
use File;
use App\TransactionSellLine;

class JTExpressShipmentRepository implements JTExpressShipmentInterface
{
    private $baseUrl = '';
    private $privateKey;
    private $customerCode;
    private $password;
    private $apiAccount;
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
        'jtexpress_prov',
        'address_id',
        'refrance_no',
        'shipmentstatus',
        'jtexpress_billcode',
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
    private $locationColumns = ['id','name','landmark','country','state','city'];
    private $jtexpressSettingsColumns = [
        'id',
        'business_id',
        'jtexpress_settings'
    ];
    private $prov;
    private $cities;
    
    public function __construct()
    {
        $this->baseUrl = config('shipments.jtexpress.baseUrl');
        $this->prov = config('shipments.jtexpress.prov');
        
        $this->cities = config('shipments.jtexpress.citites');
    }
    
    public function getEnvData($env)
    {
        $businessId = session()->get('user.business_id');
        
        // if($businessId == 145) {
        //     $env = 'test';
        // }
        $jtexpressSettings = ShipmentSetting::select($this->jtexpressSettingsColumns)->where('business_id','=',$businessId)->first();
        
        $settings = json_decode($jtexpressSettings->jtexpress_settings,true);
        
        $data = [
            'test' => [
                'key' => 'a0a1047cce70493c9d5d29704f05d0d9',
                'customerCode' => 'J0086024216',
                'password' => 'KzaMiza1',
                'apiAccount' => "292508153084379141"
            ],
            
            'live' => [
                'key' => $settings['privateKey'],
                'customerCode' => $settings['customerCode'],
                'password' => $settings['password'],
                'apiAccount' => $settings['apiAccount']
            ]
            
        ];
        
        $this->privateKey = $data[$env]['key'];
        
        $this->customerCode = $data[$env]['customerCode'];
        
        $this->password = $data[$env]['password'];
        
        $this->apiAccount = $data[$env]['apiAccount'];
        
        
    }
    
    
    public function index()
    {
        dd('index');
    }
    
    public function getContentDigest($customerCode,$password,$privateKey)
    {
        $str = strtoupper($customerCode . md5($password . 'jadada236t2')) . $privateKey;
        return base64_encode(pack('H*',strtoupper(md5($str))));
    }
    
    public function getHeaderDigest($order,$privateKey)
    {
        return base64_encode(pack('H*',strtoupper(md5(json_encode($order,JSON_UNESCAPED_UNICODE).$privateKey))));
    }
    
    public function updateSettings($inputs,$id)
    {
        
        $business_id = session()->get('user.business_id');
        // dd('test')
        $settings = ShipmentSetting::where('business_id',$business_id)->where('id',$id)->select('jtexpress_settings','id')->first();
        // dd($settings);
        $settings->jtexpress_settings = $inputs;
        
        $settings->save();
        
         $output = [
                    'success' => true,
                    'msg' => __("settings.updated_success"),
                    'url' => url('shipment')
                ];
        return $output;        
    }
    
    
    public function getOrderInfo($orderId)
    {
        return $orderId ? Transaction::select($this->transColumns)->find($orderId) : null;
    }
    
    public function getContactInfo($contactId)
    {
        return $contactId ? Contact::where('id',$contactId)->select($this->contactColumns)->first() : null;
    }
    
    public function getConteactAddress($addressId)
    {
        return $addressId ? Address::where('id',$addressId)->select($this->addressColumns)->first() : null;
    }
    
    public function generateOrderDetails($order,$contact,$address,$settings)
    {
        
        $contactName = empty($contact->name) ? $contact->first_name . ' ' . $contact->last_name : $contact->name;
        
        $items = $this->getSellItems($order->id);
        // dd($items);
        $waybillinfo = [
            "network" => "",
            "serviceType"  => "02",
            "orderType"    => "2",
            "deliveryType" => "04",  //"03" nto working
            "countryCode"  => "EG",
            "receiver"     => [
                "address"     => $address->address,
                "street"      => $address->name,
                "city"        => $this->cities[$contact->state], //$address->city,
                "mobile"      => $contact->mobile,
                "mailBox"     => $contact->email,
                "phone"       => $contact->mobile,
                "countryCode" => "EG",
                "name"        => $contactName, //$contact->first_name . ' ' . $contact->last_name ,
                "company"     => "",
                "postCode"    => "",
                "prov"        => $this->prov[$address->city], //$this->getMylerzCity($order->jtexpress_prov)
                'area' => 0,
                // "prov"        => $address->state
                
            ],
            "expressType"   => "EZ",
            "length"        => "",
            "weight"        => "1",
            "remark"        => "description goes here",
            "txlogisticId"  => $order->id,
            "goodsType"     => "ITN1",
            "priceCurrency" => "EGP",
            "totalQuantity" => 1,
            "sender"       => [
                "name" => $settings['name'],
                "address" => "", // null
                "street" => "", // null
                "city" => $this->cities[$order->location->city] , //$settings['city'],  // null
                "mobile" => $settings['mobile'],    // can not mobile and phone empty in same time
                "mailBox" => $settings['mailBox'], // null
                "phone" => $settings['phone'], // not null
                "countryCode" => $settings['countryCode'],  // null
                "company" => "", // null
                "postCode" => "", // null
                "prov" => $this->prov[$order->location->state], //$settings['prov']   // null,
                'area' => 0
            ],
            "itemsValue" => $order->final_total,
             "offerFee" =>0,
            // "items" => [
            //     // [
            //     //     "englishName" => "file",
            //     //     "number" => 1,
            //     //     "itemType" => "ITN1",
            //     //     "itemName" => "\u6587\u4ef6\u7c7b\u578b",
            //     //     "priceCurrency" => "SAR",
            //     //     "itemValue" => "2000",
            //     //     "itemUrl" => "http:\/\/www.baidu.com",
            //     //     "desc" => "file"
            //     // ]
            // ],
            "items" => $items,
            "operateType" => 1,
            "payType" => "PP_PM",  // 'FOD not working'
            "isUnpackEnabled" => 0
        ];
        
        // dd($waybillinfo);
        return $this->get_post_data($this->customerCode,$this->password,$this->privateKey,json_encode($waybillinfo));

    }
    
    public function sendRequest($inputs,$order)
    {
        // $businessId = session()->get('user.business_id');
        
        // dd($inputs);
        $head_dagest = $this->get_header_digest($inputs,$this->privateKey);
        
        $post_content = array(
            'bizContent' => $inputs
        );
        
        
        
        $postdata2 = http_build_query($post_content);
        
    
        $options = array(
        'http' => array(
            'method' => 'POST',
            'header' =>
                array(
                        'Content-type: application/x-www-form-urlencoded',
                        'apiAccount:' . $this->apiAccount,
                        'digest:' . $head_dagest,
                        'timestamp:' .  floor(microtime(true) * 1000)
                    ),
                    
                    'content' => $postdata2,
                    'timeout' => 15 * 60 
                )
        );
        
        $context = stream_context_create($options);
        //?uuid=b237d3b7b29b454ba92de4356ebb28b1'
        // if($businessId == 145) {
            
        //     $result = file_get_contents($this->$baseUrlTest . 'order/addOrder?uuid=b237d3b7b29b454ba92de4356ebb28b1', false, $context);

        //     $response = json_decode($result,true);
        
        // if($response['code'] == 1 && $response['msg'] == 'success' && ! empty($response['data'])) {
        //     // dd($response);
        //     $order->refrance_no = $response['data']['billCode'];
        //     $order->shipmentstatus = 'Ready_To_Pickup';
        //     $order->jtexpress_billcode = $response['data']['billCode'];
        //     $order->save();
            
        //     $refOrder = RefNo::where('transaction_id',$order->id)->first();
        //     if(!empty($refOrder)) {
        //                                   ;
        //             $refOrder->ref_no = $response['data']['billCode'];
                
        //             $refOrder->save();
                                            
        //         }else {
                    
        //             $input =[
                                              
        //                 'transaction_id'  => $order->id,
        //                 'order_number'    => $response['data']['billCode'],
        //                 'ref_no'          => $response['data']['billCode'],
        //             ];
                                            
        //             RefNo::create($input);
                                            
        //         }
        //     // dd($response,'ok');
        // }else {
        //     return [
        //         'status' => false,
        //         'error' => $response['msg']
        //     ];
        // }
            
        // }
        
        // ?uuid=b237d3b7b29b454ba92de4356ebb28b1
        // ?uuid=e5d756f87dd54523ac2a9148ab742974
        $result = file_get_contents($this->baseUrl . 'order/addOrder', false, $context);

        $response = json_decode($result,true);
        
        // dd($response);
        if($response['code'] == 1 && $response['msg'] == 'success' && ! empty($response['data'])) {
            // dd($response);
            $order->refrance_no = $response['data']['billCode'];
            $order->shipmentstatus = 'Ready_To_Pickup';
            $order->jtexpress_billcode = $response['data']['billCode'];
            $order->jt_sortingcode  = $response['data']['sortingCode'];
            $order->save();
            
            $refOrder = RefNo::where('transaction_id',$order->id)->first();
            if(!empty($refOrder)) {
                                          
                    $refOrder->ref_no = $response['data']['billCode'];
                
                    $refOrder->save();
                                            
                }else {
                    
                    $input =[
                                              
                        'transaction_id'  => $order->id,
                        'order_number'    => $response['data']['billCode'],
                        'ref_no'          => $response['data']['billCode'],
                    ];
                                            
                    RefNo::create($input);
                                            
                }
            // dd($response);
        }else {
            return [
                'status' => false,
                'error' => $response['msg']
            ];
        }
    }
    
    public function printOrder($id)
    {
        if (File::exists(public_path('/uploads/jtexpress/'.$id.'.pdf'))){
            return response()->download(public_path('/uploads/jtexpress/'.$id.'.pdf'));
        }
        
        
        
        $businessId = session()->get('user.business_id');
        
        $jtexpressSettings = ShipmentSetting::select($this->jtexpressSettingsColumns)->where('business_id','=',$businessId)->first();
        
        $settings = json_decode($jtexpressSettings->jtexpress_settings,true);
        
        $digest = $this->get_content_digest($settings['customerCode'],$settings['password'],$settings['privateKey']);
        
        $order   = $this->getOrderInfo($id);
        
        $waybillinfo = [
            'customerCode' => $settings['customerCode'],
            'digest' => $digest,
            'billCode' => $order->jtexpress_billcode,
            'printSize' => 0,
            'printCod' => 1
        ];
        
        $head_dagest = $this->get_header_digest(json_encode($waybillinfo),$this->privateKey);
        
        $post_content = array(
            'bizContent' => json_encode($waybillinfo)
        );
        
    
        $postdata2 = http_build_query($post_content);
        
        $options = array(
        'http' => array(
            'method' => 'POST',
            'header' =>
                array(
                        'Content-type: application/x-www-form-urlencoded',
                        'apiAccount:' . $this->apiAccount,
                        'digest:' . $head_dagest,
                        'timestamp:' .  floor(microtime(true) * 1000)
                    ),
                    
                    'content' => $postdata2,
                    'timeout' => 15 * 60 
                )
        );
        
        $context = stream_context_create($options);
        // ?uuid=b237d3b7b29b454ba92de4356ebb28b1
        // ?uuid=e5d756f87dd54523ac2a9148ab742974
        $result = file_get_contents($this->baseUrl . 'order/printOrder', false, $context);

        $data = json_decode($result,true);

        $end = base64_decode($data['data']['base64EncodeContent']);
        
        File::put(public_path('/uploads/jtexpress/'. $id . '.pdf'),$end);
        
        return response()->download(public_path('/uploads/jtexpress/' . $id . '.pdf'));
        
    }
    
    public function sendTestOrder()
    {
        $customerCode = 'J0086024216';
        $key = "a0a1047cce70493c9d5d29704f05d0d9";
        $pwd  = "KzaMiza1";
        $apiAccount = "292508153084379141";
        $openUrl = "https://demoopenapi.jtjms-eg.com/webopenplatformapi/api/order/addOrder?uuid=b237d3b7b29b454ba92de4356ebb28b1";
        
        $waybillinfo = '{
            "serviceType":"02",
            "orderType":"2",
            "deliveryType":"04",
            "countryCode":"KSA",
            "receiver":{
                "address":"Riyadh, 20 sts ",
                "street":"",
                "city":"Riyadh",
                "mobile":"0533666345",
                "mailBox":"customer@gmail.com",
                "phone":"",
                "countryCode":"KSA",
                "name":"Omar Test",
                "company":"company",
                "postCode":"000001",
                "prov":"Riyadh"
            },
            "expressType":"EZKSA",
            "length":0,
            "weight":15,
            "remark":"description goes here",
            "txlogisticId":"tttest__2-2191982-2",
            "goodsType":"ITN1",
            "priceCurrency":"SAR",
            "totalQuantity":1,
            "sender":{
                "address":"Salasa WH Sulyffff",
                "street":"",
                "city":"Riyadh",
                "mobile":"96650000000fff0",
                "mailBox":"salasa@gmail.com",
                "phone":"",
                "countryCode":"KSA",
                "name":"Salasa Test",
                "company":"company",
                "postCode":"",
                "prov":"Riyadh"
            },
            "itemsValue":10,
             "offerFee":0,
            "items":[
                {
                    "englishName":"file",
                    "number":1,
                    "itemType":"ITN1",
                    "itemName":"\u6587\u4ef6\u7c7b\u578b",
                    "priceCurrency":"SAR",
                    "itemValue":"2000",
                    "itemUrl":"http:\/\/www.baidu.com",
                    "desc":"file"
                }
            ],
            "operateType":1,
            "payType":"PP_PM",
            "isUnpackEnabled":0
        }';

        $postdata = $this->get_post_data($customerCode,$pwd,$key,$waybillinfo);
        $head_dagest = $this->get_header_digest($postdata,$key);
        $post_content = array(
            'bizContent' => $postdata
        );
        
        
        $postdata2 = http_build_query($post_content);
        $options = array(
        'http' => array(
            'method' => 'POST',
            'header' =>
                array('Content-type: application/x-www-form-urlencoded',
                    'apiAccount:' . $apiAccount,
                    'digest:' . $head_dagest,
                    'timestamp:' .  floor(microtime(true) * 1000)),
            'content' => $postdata2,
            'timeout' => 15 * 60 // 超时时间（单位:s）
        )
    );
    
    $context = stream_context_create($options);

    $result = file_get_contents($openUrl, false, $context);

    dd($result);
        // dd($postdata2);
        // dd($post_content)
        try{
                $client = new Client();
                
                $response = $client->post($openUrl,[
                    'headers' => [
                        'Content-Type' =>'application/x-www-form-urlencoded',
                        'apiAccount' => $apiAccount,
                        'digest' => $head_dagest,
                        'timestamp' => floor(microtime(true) * 1000)
                    ],
                    
                    'body' => $post_content
                ]);
                
                $responseData = json_decode($response->getBody(),true);
                dd($responseData);
            } catch(GuzzleException $e) {
                $response = $e->getResponse();
                $responseBodyAsString = $response->getBody()->getContents();
                dd($responseBodyAsString);
                
            }
    }
    
    private function get_content_digest($customerCode,$pwd,$key)
    {
        $str = strtoupper($customerCode . md5($pwd . 'jadada236t2')) . $key;

        return base64_encode(pack('H*', strtoupper(md5($str))));
    }
    
    private function get_header_digest($post,$key)
    {
        // $post = json_encode($post);
        $digest = base64_encode(pack('H*',strtoupper(md5($post.$key))));
        // dd($digest);
        return $digest;
    }
    
    private function get_post_data($customerCode,$pwd,$key,$waybillinfo)
    {
        $digest = $this->get_content_digest($customerCode,$pwd,$key);
        
        $postdate = json_decode($waybillinfo,true);
        // dd($postdate);
        $postdate['customerCode'] = $customerCode;
        $postdate['digest'] = $digest; //'tqKuSzaHKmf3iKsiVhvcVQ=='; //$this->get_content_digest($customerCode,$pwd,$key);
        // dd($postdate);
        return json_encode($postdate);
    }
    
    private function getMylerzCity($mylerzeZone)          
    {   
        $zone = [
            
            "AS"        => "Ain shams", 
            
			"Al-S"      => "Al salam",
			
			"El-M"      => "El marg",
			
			"HEl"       => "Helyoubolis",
			
			"NOZHA"     => "Nozha", 
			
			"Nasr City" => "Nasr city",
			
			"ZAMALEK"   => "Zamalek",
						    
			"EL-AZBAKIA" => "El azbakia",
						    
			"EL-MOSKY" => "El mosky",
						    
			"El-Waily" => "El waily",
 
			"Abdeen" => "Abden",

			"Bab El-Shaeria" => "Bab al sharia",

			"El-Gamalia" => "El gamalia",

			"Boulak" => "Boulak",
						    
		    "Qasr elneil" => "Qasr elneil",

			"ELdarb Elahmar" => "Eldarb elahmar",

			"Badr City" => "Badr city",

			"Basateen" => "Basateen",

			"Elsayeda Zeinab" => "Elsayeda zeinab",

		    "Hadayek El Qobah" => "Hadayek el qobah",
 
			"15th of May" => "15th may",

			"Helwan" => "Helwan",

			"Eltebeen" => "Eltebeen",
						   
            "Maadi" => "Maadi",
						   
		    "Madinaty" => "Madinaty",
		
			"Manial" => "Manial",
						   
			"Masr El Qadeema" => "Masr el qadeema",
						   
			"New Cairo" => "New cairo",
						   
			"El Shorouk" => "El shourok",
						   
		    "Shoubra" => "Shoubra<",
						  
			"Zeitoun" => "Zeitoun",
						   
			"AMRY" => "Amerya",
						   
		    "ABAG" => "Abagya",
						   
			"TURA" => "Tura",
						   
		    "HWMD" => "Hwamdya<",
					
		    "BDRA" => "Badrashain",
						   
			"HDBA" > "El hadba",
						   
		    "AYAT" => "Ayat",
						   
			"SAF" => "Alsaf",
						   
		    "GHMR" => "Ghamra<",
					
			"ZAHR" => "El zaher",
						   
			"ABAS" => "Abasya",
						   
			"SHARB" => "Sharabya",
						   
			"FRAG" => "Road el farag",
						   
			"KHSU" => "El khusus",
						  
			"ZWYA" => "Al zawya alhamra",
						   
			"KHM2" => "Shoubra el khaima",
						   
			"FUTR" => "Future city",
						   
			"NHEL" => "New hulyobles",
						   
			"OBOR" => "Al obor<",
						  
			"RMDN" => "10 of ramadan",
						   
			"ESHA" => "Alsayeda aisha",
					
			"NKHL" => "Ezbt el nakhl",
						   
			"LWAA" => "Ard ellewaa",
						   
		    "BRAG" => "El bragel",
						  
			"OSIM" => "Osim",
						   
			"GIZA" => "Giza",
						   
			"MUNB" => "Munib",
						   
			"MEKI"             => "Saket mekki",
						   
		    "NMRS"             => "Abou el nomros<",
						  
			"SMAN"             => "Nazlet elsman",
						   
			"TLBA"             => "Talbya",
						   
			"RWSH"             => "Abou rawash",
						   
		    "Agouza"           => "Agouza<",
						  
			"Dokki"            => "Dokki",
						   
			"Boulak Eldakrour" => "Boulak Eldakrour",
						   
			"Hadayek Al Ahram" => "Hadayek Al Ahram",
						   
			"Haram" => "Haram",
						   
		    "Imbaba" => "Imbaba",
						  
			"Mohandseen" => "Mohandseen",
						   
			"6th of Oct" => "6th of Oct",
						   
			"Sheikh Zayed" => "Sheikh Zayed",
						   
			"Omranyea" => "Omranyea",
						   
		    "Warraq" => "Warraq<",
						  
			"Alexandria" => "Alexandria",
						   
			"ASYT" => "Asuit",
						   
			"ASWN" => "Aswan",
						   
			"BEHR" => "Behaira",
						   
		    "BENS" => "Bani suef",
						  
			"DAKH" => "Dakahlya",
						   
			"DAMT" => "Damita",
						   
			"FAYM" => "Fayoum",
						   
			"GHRB" => "Gharbya",
						   
		    "ISML" => "Ismalya",
						  
			"SHKH" => "Kafr elsheigh",
						   
			"LUXR" => "Luxour",
						   
	        "MTRH" => "Matrouh",
						 
			"MNYA" => "Minya",
						   
			"MONF" => "Monofya",
						   
			"WADI" => "Elwasi elgadid",
						   
		    "NSNA" => "North sina",
						  
			"PORS" => "Port said",
						   
			"QLYB" => "Qalyoubya",
						   
			"QENA" => "qena",
						   
			"REDS" => "Qed sea",
						   
		    "SHRK" => "Sharkya",
						  
			"SOHG" => "Sohag",
						   
			"SSINA" => "South sina",
						   
		    "SUEZ" => "Suez",
						  
			"NorthCoast" => "North coast",
						   
        ];
        
        if(array_key_exists($mylerzeZone,$zone)){
            return $zone[$mylerzeZone];
        }
    }
    
    private function getSellItems($orderId)
    {
        $sellTransactions    = TransactionSellLine::where('transaction_id','=',$orderId)->select(['product_id','variation_id','quantity'])->get();
        
        $items = [];
        foreach($sellTransactions as $sellItem) {
            // $name = empty($variation->product->name) ? $variation->product->name_ar : $variation->product->name;
            $item = [
                'englishName' => ! empty($sellItem->variations->product->name) ? $sellItem->variations->product->name : '',
                'itemName' => empty($sellItem->variations->product->name) ? $sellItem->variations->product->name_ar : $sellItem->variations->product->name ,
                'itemValue' => $sellItem->variations->sell_price_inc_tax
            ];
            array_push($items,$item);
            // dd($item);
            // dd($sellItem->variations->product);
        }
        
        return $items;
    }
    
    public function cancelOrder($id)
    {
        // dd($this->apiAccount);
        $businessId = session()->get('user.business_id');
        
        $jtexpressSettings = ShipmentSetting::select($this->jtexpressSettingsColumns)->where('business_id','=',$businessId)->first();
        
        $settings = json_decode($jtexpressSettings->jtexpress_settings,true);
        
        $digest = $this->get_content_digest($settings['customerCode'],$settings['password'],$settings['privateKey']);
        
        $order   = $this->getOrderInfo($id);
        
         $waybillinfo = [
            'customerCode' => $settings['customerCode'],
            'digest' => $digest,
            // 'billCode' => $order->jtexpress_billcode,
            'orderType' => 1,
            'txlogisticId' => $order->id,
            'reason' => 'test'
        ];
        
        $head_dagest = $this->get_header_digest(json_encode($waybillinfo),$this->privateKey);
        
         $post_content = array(
            'bizContent' => json_encode($waybillinfo)
        );
        
    
        $postdata2 = http_build_query($post_content);
        
        $options = array(
        'http' => array(
            'method' => 'POST',
            'header' =>
                array(
                        'Content-type: application/x-www-form-urlencoded',
                        'apiAccount:' . $this->apiAccount,
                        'digest:' . $head_dagest,
                        'timestamp:' .  floor(microtime(true) * 1000)
                    ),
                    
                    'content' => $postdata2,
                    'timeout' => 15 * 60 
                )
        );
        
        $context = stream_context_create($options);
        // ?uuid=b237d3b7b29b454ba92de4356ebb28b1
        // ?uuid=e5d756f87dd54523ac2a9148ab742974
        $result = file_get_contents($this->baseUrl . 'order/cancelOrder', false, $context);

        $response = json_decode($result,true);
        
        // dd($response);
        if($response['code'] == 1 && $response['msg'] == 'success' && ! empty($response['data'])) {
            
            $order->refrance_no = null;
            $order->shipmentstatus = null;
            $order->jtexpress_billcode = null;
            $order->save();
            
            if (File::exists(public_path('/uploads/jtexpress/'.$id.'.pdf'))){
                
                unlink(public_path('/uploads/jtexpress/'.$id.'.pdf'));
                
            }
        } else {
            return [
                'status' => false,
                'error' => $response['msg']
            ];
        }
    }
}