<?php

namespace App\Repositories\ApiIntegrate;

use App\Interfaces\ApiIntegrate\ShopifyInterface;
use DB;
use Illuminate\Http\Request;
use App\Models\Shopify;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Models\ShopifySyncLog;
use App\Contact;
use App\Address;
use App\Product;

class ShopifyRepository implements ShopifyInterface
{
    
    // private $shop = 'vowalaa-erp-store.myshopify.com';
    // private $apiKey = 'ca506d1318c67f97a85ff1b3525a5e3c';
    // private $apiSecretKey = '9a1488497862c0b68effe1c6934316b9';
    // private $scopes = ['read_products,write_products,read_orders'];
    private $nonce;
    // private $accessMode = 'per-user';
    private $redirectUrl = 'https://erp2.vowalaaerp.com/shopify/token';
    
    public function __construct(Request $request)
    {
        $this->nonce = bin2hex(random_bytes(12));
    }
    public function index($request)
    {
        return view('shopify.index');
    }
    
    public function apiSettings()
    {
        $businessId = request()->session()->get('business.id');
        $businessShopify = Shopify::select(['id','business_id','api_token','secret_key','scopes','access_mode','shop_name'])->where('business_id',$businessId)->first();
        return view('shopify.settings',compact('businessShopify'));
    }
    
    public function updateSettings($request)
    {
        
        $data = $request->validate([
            'shop_name' => ['required'],
            'api_token' => ['required'],
            'secret_key' => ['required']
        ]);
        
        // dd($data);
        $businessId = request()->session()->get('business.id');
        $data['business_id'] = $businessId;
        DB::table('shopify')->where('business_id',$businessId)->update($data);
        session()->flash('success','Data has been saved successfuley');
        return redirect()->route('shopify.api-settings');
        
    }
    
    public function install($request)
    {
        
        $businessId = request()->session()->get('business.id');
        
        $businessShopify = Shopify::select(['id','business_id','api_token','secret_key','scopes','access_mode','shop_name'])->where('business_id',$businessId)->first();
        if (! empty($businessShopify)){
            $this->apiKey = $businessShopify->api_token;
        
            $this->apiSecretKey = $businessShopify->secret_key;
        
            $this->scopes = $businessShopify->scopes;
        
            $this->accessMode = $businessShopify->access_mode;
        
            $this->shop = $businessShopify->shop_name . '.myshopify.com';
        
            return redirect($this->generateOauthUrl());
        }
        
        return redirect()->route('shopify.api-settings');
        // return $this->generateOauthUrl();
    }
    
    public function token($request)
    {
        $businessId = request()->session()->get('business.id');
        
        $businessShopify = Shopify::select(['id','business_id','api_token','secret_key','scopes','access_mode','shop_name'])->where('business_id',$businessId)->first();
        
        $hmac = $request->input('hmac');
        
        $code = $request->input('code');
        
        $shopUrl = $request->input('shop');
        
        $parameters = array_diff_key($request->query(),array('hmac' => ''));
        
        unset($parameters['url']);
        
        ksort($parameters);
        
        // dd($parameters);
        $newHmac = hash_hmac('sha256',http_build_query($parameters),$businessShopify->secret_key);
        
        if(hash_equals($hmac,$newHmac)){
            
            $accessTokenEndPoint = 'https://' . $shopUrl .'/admin/oauth/access_token';
            $var = [
                    'client_id' => $businessShopify->api_token,
                    'client_secret' => $businessShopify->secret_key,
                    'code' => $code
                ];
                
            $curl = curl_init();
            
            curl_setopt($curl, CURLOPT_URL, $accessTokenEndPoint);
            
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            
            curl_setopt($curl, CURLOPT_POST, count($var));
            
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($var));
            
            $response = curl_exec($curl);
            
            curl_close($curl);
            
            $response = json_decode($response,true);
            
            // return $response['access_token'];
            
            $data = [];
            
            $data['access_token'] = $response['access_token'];
            
            $data['hmac'] = $hmac;
            
            $data['install_date'] = NOW();
            
            $data['is_install'] = 1;
            
            DB::table('shopify')->where('business_id',$businessId)->update($data);
            
            session()->flash('success','Your Shopify App Installed Successfulley');
            
            return redirect()->route('shopify.api-settings');
            
        } else {
            dd('no zayed');
        }
        
    }
    
    
    public function sync($item)
    {
        $businessId = request()->session()->get('business.id');
        
        $businessShopify = Shopify::select(['id','business_id','api_token','secret_key','scopes','access_mode','shop_name','access_token'])->where('business_id',$businessId)->first();
        
        // return 'ok';
        return $this->restApi($businessShopify->shop_name . '.myshopify.com','/admin/api/2022-04/products.json',[]);
        dd($businessShopify);
    }
    
    private function generateOauthUrl()
    {
        return 'https://' . $this->shop . '/admin/oauth/authorize?client_id=' . $this->apiKey . '&scope=' . $this->scopes . '&redirect_uri=' . urlencode($this->redirectUrl) . '&state=' . $this->nonce . '&grant_options[]=' . $this->accessMode;
        // return 'https://' . $this->shop . '/admin/oauth/authorize?client_id=' . $this->apiKey . '&scope=' . $this->generateScopes() . '&redirect_uri=' . urlencode($this->redirectUrl) . '&state=' . $this->nonce . '&grant_options[]=' . $this->accessMode;
    }
    
    private function generateScopes()
    {
        return implode(',',$this->scopes);
    }
    
    // /admin/api/2022-04/products.json
    private function restApi($shop, $endPoint, $params = [], $method = "GET")
    {
        $url = 'https://' . $shop . $endPoint;
        return $url;
    }
    
    public function addCategory()
    {
        $businessId = request()->session()->get('business.id');
        
        $businessShopify = Shopify::select(['id','business_id','api_token','secret_key','scopes','access_mode','shop_name','access_token'])->where('business_id',$businessId)->first();
        
        $url = 'https://' . $businessShopify->shop_name . '.myshopify.com' . '/admin/api/2022-04/customers.json';
    
        $token = $businessShopify->access_token;
        
        $client = new Client();
        
        $customerData = array
        (
            "customer" => array(
                "first_name"    =>  "Steve",
                "last_name"     =>  "Lastnameson",
                "email"         =>  "steve.lastnameson10@test.com",
                "verified_email"=>  true,
                "addresses"     =>  array(
                    0 => array(
                        "address1"  =>  "123 Oak St",
                        "city"      =>  "Ottawa",
                        "country"   =>  "CA",
                        "first_name"=>  "Mother",
                        "last_name" =>  "Lastnameson",
                        "phone"     =>  "555-1212",
                        "province"  =>  "ON",
                        "zip"       =>  "123 AB"
                    )
                )
            )
        );
        // dd('ok');
        $request  = $client->get($url);
        // dd($request);
        // dd($request);
        $request->setHeader("X-Shopify-Access-Token",$token);
        $request->setHeader('Content-Type','application/json');
        dd($request);
         $response = $request->send();
        $data = $response->getBody(true);
        var_dump($data);
        // $response = $client->request("POST",$url,[
        //     'headers' => ['Content-Type' => 'application/json',
        //     'Authorization' => 'X-Shopify-Access-Token '. $token],
        //     'body' => $data
            
        //     ]
        // ]);
        
        dd('ok');
        dd(json_decode($response->getBody(),true));
        
        
    }
    
    
    /**
     * Retrives last synced date from the database
     * @param id $business_id
     * @param string $type
     * @param bool $for_humans = true
     */
    public function getLastSync($business_id, $type, $for_humans = true)
    {
    //   return $business_id;
        $last_sync = ShopifySyncLog::where('business_id', $business_id)
                            ->where('sync_type', $type)
                            ->max('created_at');

        //If last reset present make last sync to null
        $last_reset = ShopifySyncLog::where('business_id', $business_id)
                            ->where('sync_type', $type)
                            ->where('operation_type', 'reset')
                            ->max('created_at');
        if (!empty($last_reset) && !empty($last_sync) && $last_reset >= $last_sync) {
            $last_sync = null;
        }

        if (!empty($last_sync) && $for_humans) {
            $last_sync = \Carbon::createFromFormat('Y-m-d H:i:s', $last_sync)->diffForHumans();
        }
        return $last_sync;
    }
    
    
    public function getCustomers()
    {
        $businessId = request()->session()->get('business.id');
        
        $businessShopify = Shopify::select(['id','business_id','api_token','secret_key','scopes','access_mode','shop_name','access_token'])->where('business_id',$businessId)->first();
        
        $url = 'https://' . $businessShopify->shop_name . '.myshopify.com' . '/admin/api/2022-04/customers.json';
        
        $token = $businessShopify->access_token;
        
        $client = new Client();
        // dd('ok');
        // $customerData = array
        // (
        //     "customer" => array(
        //         "first_name"    =>  "Steve",
        //         "last_name"     =>  "Lastnameson",
        //         "email"         =>  "steve.lastnameson10@test.com",
        //         "verified_email"=>  true,
        //         "addresses"     =>  array(
        //             0 => array(
        //                 "address1"  =>  "123 Oak St",
        //                 "city"      =>  "Ottawa",
        //                 "country"   =>  "CA",
        //                 "first_name"=>  "Mother",
        //                 "last_name" =>  "Lastnameson",
        //                 "phone"     =>  "555-1212",
        //                 "province"  =>  "ON",
        //                 "zip"       =>  "123 AB"
        //             )
        //         )
        //     )
        // );
        $response = $client->request("GET",$url,[
            'headers' => ['Content-Type' => 'application/json','X-Shopify-Access-Token' => $token]
            // 'body' => json_encode($customerData)
        ]);
        // dd('ok');
        // $request->setHeader("X-Shopify-Access-Token",$token);
        // $request->setHeader("Content-Type",'application/json');
        // $request = $client->get('https://' . $businessShopify->shop_name . '.myshopify.com' . '/admin/api/2022-04/customers.json');
        // dd('ok');
        
        // $response = $request->send();
        // dd($response);
        $responseData = json_decode($response->getBody(),true);
        dd($responseData);
        foreach($responseData['customers'] as $customer) {
            
            list($customerContactData,$customerAddressData) = $this->prepareCustomer($customer);
            
            $contact = Contact::create($customerContactData);
            
            $customerAddressData['contact_id'] = $contact->id;
            //Address
            $address = Address::create($customerAddressData);
            dd($address);
            // DB::table('addresses')->insert($customerAddressData);
            
            dd($customerAddressData);
            dd($contact);
            // var_dump($customerData);
        }
        // echo '</pre>';
    }
    
    
    private function prepareCustomer(& $customer)
    {
        return [
            '0' => [
                'type' => 'customer',
                'contact_id' => (string) $customer['id'],
                'business_id' => request()->session()->get('business.id'),
                'shopify_id' => 254872,
                'email' => $customer['email'],
                'created_at' => date('Y-m-d H:i:s', strtotime($customer['created_at'])),
                'updated_at' => date('Y-m-d H:i:s', strtotime($customer['updated_at'])),
                'first_name' => $customer['first_name'],
                'last_name' => $customer['last_name'],
                'name' => $customer['first_name'] . ' '. $customer['last_name'],
                // 'phone' => $customer['phone'],
                'city' => $customer['default_address']['city'],
                'country' => $customer['default_address']['country'],
                'address_line_1' => $customer['default_address']['address1'],
                'mobile' => $customer['default_address']['phone'],
                'created_by' => request()->session()->get('user.id'),
                'zip_code' => $customer['default_address']['zip']
            ],
            
            '1' => [
                'business_id' => request()->session()->get('business.id'),
                // 'shopify_id' => 254872154,
                'name' => $customer['default_address']['name'],
                'address' => $customer['default_address']['address1'],
                'city' => $customer['default_address']['city'],
                'country' => $customer['default_address']['country'],
                'phone' => $customer['default_address']['phone'],
                'mobile' => $customer['default_address']['phone'],
                'state' => $customer['default_address']['city'],
                'created_at' => date('Y-m-d H:i:s', strtotime($customer['created_at'])),
                'updated_at' => date('Y-m-d H:i:s', strtotime($customer['updated_at'])),
                'is_default' => 1
            ]
        ];
    }
    
    public function getCustomCollections()
    {
        $businessId = request()->session()->get('business.id');
        
        $businessShopify = Shopify::select(['id','business_id','api_token','secret_key','scopes','access_mode','shop_name','access_token'])->where('business_id',$businessId)->first();
        
        $url = 'https://' . $businessShopify->shop_name . '.myshopify.com' . '/admin/api/2021-10/smart_collections.json';
        
        $token = $businessShopify->access_token;
        
        $client = new Client();
    
        $response = $client->request("GET",$url,[
            'headers' => ['Content-Type' => 'application/json','X-Shopify-Access-Token' => $token],
        ]);
        
        
        $responseData = json_decode($response->getBody(),true);
        dd($responseData);
    }
    
    
    public function addCustomer()
    {
        $businessId = request()->session()->get('business.id');
        
        $businessShopify = Shopify::select(['id','business_id','api_token','secret_key','scopes','access_mode','shop_name','access_token'])->where('business_id',$businessId)->first();
        
        $url = 'https://' . $businessShopify->shop_name . '.myshopify.com' . '/admin/api/2022-04/customers.json';
        
        $token = $businessShopify->access_token;
        
        // $contacts = Contact::where('type','customer')->where('business_id',$businessId)->get();
        // dd($contacts);
        $client = new Client();
        $customerData = array
        (
            "customer" => array(
                "first_name"    =>  "Steve2",
                "last_name"     =>  "Lastnameson2",
                "email"         =>  "steve.lastnameson100@test.com",
                "verified_email"=>  true,
                // "addresses"     =>  array(
                //     0 => array(
                //         "address1"  =>  "123 Oak St",
                //         "city"      =>  "Ottawa",
                //         "country"   =>  "CA",
                //         "first_name"=>  "Mother",
                //         "last_name" =>  "Lastnameson",
                //         "phone"     =>  "555-1212",
                //         "province"  =>  "ON",
                //         "zip"       =>  "123 AB"
                //     )
                // )
            )
        );
        $response = $client->request("POST",$url,[
            'headers' => ['Content-Type' => 'application/json','X-Shopify-Access-Token' => $token],
            'body' => json_encode($customerData)
        ]);
        
        dd('done');
    }
    
    public function addProducts()
    {
        $businessId = request()->session()->get('business.id');
        
        $businessShopify = Shopify::select(['id','business_id','api_token','secret_key','scopes','access_mode','shop_name','access_token'])->where('business_id',$businessId)->first();
        
        $url = 'https://' . $businessShopify->shop_name . '.myshopify.com' . '/admin/api/2022-04/products.json';
        
        $token = $businessShopify->access_token;
        
        // $products = Product::where('business_id',$businessId)->get();
        // dd($products);
        // dd($contacts);
        $client = new Client();
        $customerData = array
        (
            "product" => array(
                "title"    =>  "Burton Custom Freestyle 151",
                "body_html"     =>  "<strong>Good snowboard!</strong>",
                "vendor"         =>  "Burton",
                "product_type"=>  "Snowboard",
                "created_at" => "2022-03-11T11:32:27-05:00",
                "updated_at" => "2022-03-11T11:32:27-05:00",
                "published_at" => "2022-03-11T11:32:27-05:00",
                "template_suffix" => null,
                "status" => "active"
            )
        );
        $response = $client->request("POST",$url,[
            'headers' => ['Content-Type' => 'application/json','X-Shopify-Access-Token' => $token],
            'body' => json_encode($customerData)
        ]);
        
        dd('done');
    }
    
    public function getOrders()
    {
        $businessId = request()->session()->get('business.id');
        
        $businessShopify = Shopify::select(['id','business_id','api_token','secret_key','scopes','access_mode','shop_name','access_token'])->where('business_id',$businessId)->first();
        
        $url = 'https://' . $businessShopify->shop_name . '.myshopify.com' . '/admin/api/2022-04/orders.json?status=any';
        
        $token = $businessShopify->access_token;
        
        $client = new Client();
        
        $response = $client->request("GET",$url,[
            'headers' => ['Content-Type' => 'application/json','X-Shopify-Access-Token' => $token]
        ]);
        
        $responseData = json_decode($response->getBody(),true);
        dd($responseData);
    }
    
    public function getDraftOrders()
    {
        $businessId = request()->session()->get('business.id');
        
        $businessShopify = Shopify::select(['id','business_id','api_token','secret_key','scopes','access_mode','shop_name','access_token'])->where('business_id',$businessId)->first();
        
        $url = 'https://' . $businessShopify->shop_name . '.myshopify.com' . '/admin/api/2022-04/draft_orders.json';
        
        $token = $businessShopify->access_token;
        
        $client = new Client();
        
        $response = $client->request("GET",$url,[
            'headers' => ['Content-Type' => 'application/json','X-Shopify-Access-Token' => $token]
        ]);
        
        $responseData = json_decode($response->getBody(),true);
        dd($responseData);
    }
}