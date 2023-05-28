<?php

namespace App\Http\Controllers\Admin;
use App\Http\traits\MylerzTrait;
use App\Http\traits\AramexTrait;
use App\Http\traits\BostaTrait;
use App\Models\ShipmentSetting;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Datatables;
use Carbon\Carbon;
use App\Models\Country;
use App\Models\City;
use App\Models\Zone;
use App\Models\ShippingType;
use App\Models\Piece;
use App\Arabian\ShippingTypeArabian;
use App\Models\Product;
use App\Models\Propiece;
use App\Models\Free;
use App\Models\Profree;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Utils\ModuleUtil;
use App\Transaction;
use App\Contact;
use App\Address;
use Validator;

class ShippmentSetingsController extends Controller
{
    
    use MylerzTrait; 
    use AramexTrait;
    use BostaTrait; 

    
    protected $moduleUtil;
    public $b;

    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct(ModuleUtil $moduleUtil)
    {
            $this->moduleUtil = $moduleUtil;
    
    }
        
    
 
               public function mylerzshipment($id)
                {
      
                      
                     
                     $order= Transaction::where('barcod',$id)->first();
                       
                       $b = ShipmentSetting::where('business_id',$order->business_id)->first();
                        
                        $client = new Client([
                            
                        'headers' => ['Content-Type' =>'application/x-www-form-urlencoded']
                      
                       ]);
                
                          $response = $client->post('https://integration.mylerz.net/Token',  
                         
                           ['form_params' => [ 
                              
                                "grant_type"=>"password",
                                "username"=>$b->mylerz_user,
                                "password"=>$b->mylerz_password,
                        
                                ],
                            ]); 
                                  
                       
                       $m = json_decode($response->getBody(), true);
                       
                       $n= $m['access_token'];
                         
                         
                 $client = new Client([
                     
                      'headers' => ['Content-Type' =>'application/json','Authorization'=>"Bearer $n"]
                 ]);
                
                  $response = $client->get('https://integration.mylerz.net/api/packages/GetPackageDetails?AWB='.$id.'');
                  
                   $m = json_decode($response->getBody(), true);
                   
                   return view('admin.shipment.mylerzshow',compact('m')); 
      
                            
                            
                            
                            
                            
                            
                           /* $order= Transaction::findOrFail($id);
                            
                             $contacts= Contact::where('id',$order->contact_id)->first();

                             $addresses= Address::where('id',$order->address_id)->first();

                             $b = ShipmentSetting::where('business_id',$order->business_id)->first();
       
                                $client = new Client([
                    
                                'headers' => ['Content-Type' =>'application/x-www-form-urlencoded']
                      
                                ]);
                
                               $response = $client->post('https://integration.mylerz.net/Token',  
                         
                              ['form_params' => [ 
                              
                                "grant_type"=>"password",
                                "username"=>$b->mylerz_user,
                                "password"=>$b->mylerz_password,
                                
                                ],
                            ]); 
                                 
                                 $m = json_decode($response->getBody(), true);
                                 $n= $m['access_token'];
                                 $nowtimz =date("Y-m-d");
                                 $d=strtotime("+2 Days"); 
                                
                                 $mylerz = array(
                                      
                                  array(
                                      
                                   "PickupDueDate"=> date("Y-m-d",$d),
                                    "Package_Serial"=> 1, 
                                    "Reference"=>$order->invoice_no,
                                    "Description"=> "A package with  1 items be sure that be received",
                                    "Total_Weight"=> 0,
                                    "Service_Type"=>$order->service_types,
                                    "Service"=> "SD",
                                    "Service_Category"=> "Delivery",
                                    "Payment_Type"=> "COD",
                                    "COD_Value"=> $order->final_total,
                                    "Customer_Name"=> $contacts->name,
                                    "Mobile_No"=>$contacts->mobile,
                                    "Street"=>$addresses->address,
                                    "Country"=>"Egypt",
                                    "Neighborhood"=>$order->ships_zone,
                                    
                                    "Pieces"=>array(
                                        
                                   array(
                                    
                                    "PieceNo"=> 1,

                                            )
                                        )
                                    ),
                            
                                    );

                                $d= $mylerz;
                                
                                $data = json_encode($d);
                                   
                                $client = new Client([
                                    
                                 'headers' => ['Content-Type' =>'application/json','Authorization'=>"Bearer $n "]
                                  
                                ]);
                
                                   $response = $client->post('https://integration.mylerz.net/api/Orders/AddOrders',
                 
                                    ['body' =>$data]
                      
                                  );
                
                                       $m = json_decode($response->getBody(), true);
                                      dd($m);
                                      
                                       $order['barcod']= $m['Value']['Packages'][0]['BarCode'];
                                       $order['mylerz_status']= $m['Value']['Packages'][0]['Status'];
                                       $shipment_status = $m['Value']['Packages'][0]['Status'];
                                       $order['shipmentstatus']="Mylerz  $shipment_status";
                                       $order->save();
                                       */
                                      
                                       
                            
      
    }   
    
    
               public function aramexshipment($id){
                   
                      
                   $order= Transaction::where('AramexApi',$id)->first();

                          $b = ShipmentSetting::where('business_id',$order->business_id)->first();
                          
                          $aramex=array(
                              
                           "ClientInfo"=>array(
                               
                            "UserName"=>$b->aramex_user,
                            "Password"=>$b->aramex_password,
                            "Version"=>"v1",
                            "AccountNumber"=>$b->aramex_number,
                            "AccountPin"=>  $b->aramex_pin,
                            "AccountEntity"=> $b->aramex_entity,
                            "AccountCountryCode"=> "EG",
                            "Source"=> 24
                            
                            ),
                       
                       "GetLastTrackingUpdateOnly"=> false,
                        "Shipments"=>array(
                         "$id"
                    
                        ),
                        "Transaction"=>array(
                            "Reference1"=> "",
                            "Reference2"=> "",
                            "Reference3"=> "",
                            "Reference4"=> "",
                            "Reference5"=> "",
                        ),
                    );
                        
                                   
                    
                      
                      $d=$aramex;
                      $data = json_encode($d) ;
                      $client = new Client([
                      'headers' => ['Content-Type' =>'application/json','Accept'=>'application/json']
                     ]);
                
                     $response = $client->post("$b->aramex_link/ShippingAPI.V2/Tracking/Service_1_0.svc/json/TrackShipments",
                
                          ['body' =>$data]
                     
                     );
                
                   $m = json_decode($response->getBody(), true);
                   
                   return view('admin.shipment.aramex-picks',compact('m')); 
                   
                 
                   
                   
                            
                    /*  $order= Transaction::find($id);
                          $b = ShipmentSetting::where('business_id',$order->business_id)->first();

                          $contacts= Contact::where('id',$order->contact_id)->first();
                        
                           
                           $nowtimz =strtotime("2:00pm +1 days 5 seconds") * 1000;
                           $date = strtotime("10:00am +6 days 5 seconds")* 1000;
                              
                                $aramex=array(

                                 "ClientInfo"=>array(
                                    
                                    "UserName"=>$b->aramex_user,
                                    "Password"=>$b->aramex_password,
                                    "Version"=>"v1",
                                    "AccountNumber"=>$b->aramex_number,
                                    "AccountPin"=>  $b->aramex_pin,
                                    "AccountEntity"=> $b->aramex_entity,
                                    "AccountCountryCode"=> "EG",
                                    "Source"=> 24
                                   
                                   ),
                              
                                         "LabelInfo"=>array(
                                            "ReportID"=>9201,
                                            "ReportType"=>"URL"
                                        
                                        ),
                                        "Pickup"=>array(
                                            "PickupAddress"=>array(
                                                "Line1"=> "Test",
                                                "Line2"=> "",
                                                "Line3"=> "",
                                                "City"=> "Cairo",
                                                "StateOrProvinceCode"=> "",
                                                "PostCode"=>"",
                                                "CountryCode"=> "EG",
                                                "Longitude"=> 0,
                                                "Latitude"=> 0,
                                                "BuildingNumber"=> null,
                                                "BuildingName"=> null,
                                                "Floor"=> null,
                                                "Apartment"=> null,
                                                "POBox"=>null,
                                                "Description"=> null
                                            
                                            
                                            ),
                                            "PickupContact"=>array(
                                                "Department"=>"",
                                                "PersonName"=> "test",
                                                "Title"=> "",
                                                "CompanyName"=>"test",
                                                "PhoneNumber1"=> "1111111111111",
                                                "PhoneNumber1Ext"=> "",
                                                "PhoneNumber2"=>"",
                                                "PhoneNumber2Ext"=> "",
                                                "FaxNumber"=>"",
                                                "CellPhone"=>"11111111111111",
                                                "EmailAddress"=> "test@test.com",
                                                "Type"=> ""
                                           
                                              ),
                                               
                                            
                                            "PickupLocation"=> "test",
                                            "PickupDate"=>"/Date($date)/",
                                            "ReadyTime"=>"/Date($nowtimz)/",
                                            "LastPickupTime"=> "/Date($nowtimz)/",
                                            "ClosingTime"=> "/Date($nowtimz)/",
                                            "Comments"=>"",
                                            "Reference1"=> "001",
                                            "Reference2"=>"",
                                             "Vehicle"=>"",
                                      
                                             "Shipments"=>array(
                                                "Reference1"=> "",
                                                "Reference2"=> "",
                                     
                                          array(
                                            "Reference3"=> "",
                                            "Shipper"=>array(
                                            "Reference1"=> "",
                                            "Reference2"=> "",
                                            "AccountNumber"=>$b->aramex_number,
                                            "PartyAddress"=>array(
                                                "Line1"=>$order->landmark,
                                                "Line2"=> "",
                                                "Line3"=> "",
                                                "City"=> "Cairo",
                                                "StateOrProvinceCode"=>"",
                                                "PostCode"=> "",
                                                "CountryCode"=>"EG",
                                                "Longitude"=> 0,
                                                "Latitude"=> 0,
                                                "BuildingNumber"=> null,
                                                "BuildingName"=> null,
                                                "Floor"=>null,
                                                "Apartment"=> null,
                                                "POBox"=> null,
                                                "Description"=> null
                                                 
                                                ),
                                        
                                               "Contact"=>array(
                                               "Department"=> "",
                                                "PersonName"=>$order->name,
                                                "Title"=> "",
                                                "CompanyName"=> "aramex",
                                                "PhoneNumber1"=>$order->mobile,
                                                "PhoneNumber1Ext"=> "",
                                                "PhoneNumber2"=> "",
                                                "PhoneNumber2Ext"=> "",
                                                "FaxNumber"=> "",
                                                "CellPhone"=> "9677956000200",
                                                "EmailAddress"=> $order->email,
                                                "Type"=> ""
                                                ),
                                                ),
                                            "Consignee"=>array(
                                                
                                            "Reference1"=> "",
                                            
                                            "Reference2"=> "",
                                            
                                            "AccountNumber"=> "",
                                            
                                            "PartyAddress"=>array(
                                                "Line1"=>"Test",
                                                "Line2"=> "",
                                                "Line3"=> "",
                                                "City"=> "Cairo",
                                                "StateOrProvinceCode"=> "",
                                                "PostCode"=>"",
                                                "CountryCode"=> "EG",
                                                "Longitude"=> 0,
                                                "Latitude"=> 0,
                                                "BuildingNumber"=> "",
                                                "BuildingName"=> "",
                                                "Floor"=>"",
                                                "Apartment"=> "",
                                                "POBox"=> null,
                                                "Description"=>""
                                            
                                            ),
                                            
                                            "Contact"=>array(
                                                "Department"=> "",
                                                "PersonName"=> "aramex",
                                                "Title"=> "",
                                                "CompanyName"=> "aramex",
                                                "PhoneNumber1"=> "009625515111",
                                                "PhoneNumber1Ext"=>"",
                                                "PhoneNumber2"=> "",
                                                "PhoneNumber2Ext"=> "",
                                                "FaxNumber"=> "",
                                                "CellPhone"=> "9627956000200",
                                                "EmailAddress"=> "test@test.com",
                                                "Type"=> ""
                                    
                                               
                                              ),
                                              ),
                        
                                          "ThirdParty"=>array(
                                              
                                             "Reference1"=> "",
                                             "Reference2"=> "",
                                             "AccountNumber"=> "",
                                             "PartyAddress"=>array(
                                                "Line1"=>"",
                                                "Line2"=> "",
                                                "Line3"=> "",
                                                "City"=> "",
                                                "StateOrProvinceCode"=>"",
                                                "PostCode"=>"",
                                                "CountryCode"=> "",
                                                "Longitude"=> 0,
                                                "Latitude"=> 0,
                                                "BuildingNumber"=> null,
                                                "BuildingName"=> null,
                                                "Floor"=> null,
                                                "Apartment"=> null,
                                                "POBox"=>null,
                                                "Description"=> null
                                            
                                            ),
                                                
                                            "Contact"=>array(
                                                "Department"=>"",
                                                "PersonName"=> "",
                                                "Title"=>"",
                                                "CompanyName"=> "",
                                                "PhoneNumber1"=> "",
                                                "PhoneNumber1Ext"=> "",
                                                "PhoneNumber2"=> "",
                                                "PhoneNumber2Ext"=> "",
                                                "FaxNumber"=> "",
                                                "CellPhone"=> "",
                                                "EmailAddress"=> "",
                                                "Type"=> ""
                                        ),
                                        ),
                                        
                                        "ShippingDateTime"=> "/Date($nowtimz)/",
                                        "DueDate"=> "/Date($nowtimz)/",
                                        "Comments"=> "",
                                        "PickupLocation"=> "",
                                        "OperationsInstructions"=> "",
                                        "AccountingInstrcutions"=> "",
                                        "Details"=>array(
                                            "Dimensions"=> null,
                                            "ActualWeight"=>array(
                                                "Unit"=>"KG",
                                                "Value"=> 0.5
                                             
                                             ),
                                            "ChargeableWeight"=> null,
                                            "DescriptionOfGoods"=>"Books",
                                            "GoodsOriginCountry"=> "JO",
                                            "NumberOfPieces"=> 1,
                                            "ProductGroup"=> "EXP",
                                            "ProductType"=> "PDX",
                                            "PaymentType"=> "P",
                                            "PaymentOptions"=> "",
                                            "CustomsValueAmount"=> null,
                                            "CashOnDeliveryAmount"=> null,
                                            "InsuranceAmount"=> null,
                                            "CashAdditionalAmount"=> null,
                                            "CashAdditionalAmountDescription"=> "",
                                            "CollectAmount"=> null,
                                            "Services"=> "",
                                            "Items"=>array(
                                                
                                                ),
                                         
                                          ),
                                    
                                        "Attachments"=>array(
                                        ),
                                        "ForeignHAWB"=> "",
                                        "TransportType"=>0,
                                        "PickupGUID"=>"",
                                        "Number"=> null,
                                        "ScheduledDelivery"=> null
                                   
                                         ),
                                         ),
                                         
                                         
                                            "PickupItems"=>array(
                                             
                                                array(
                                                 
                                                "ProductGroup"=> "EXP",
                                                "ProductType"=> "PDX",
                                                "NumberOfShipments"=> 1,
                                                "PackageType"=> "Box",
                                                "Payment"=> "P",
                                                "ShipmentWeight"=>array(
                                                    "Unit"=> "KG",
                                                    "Value"=> 0.5
                                                ),
                                                "ShipmentVolume"=> null,
                                                "NumberOfPieces"=> 1,
                                                "CashAmount"=> null,
                                                "ExtraCharges"=> null,
                                                "ShipmentDimensions"=>array(
                                                    "Length"=>0,
                                                    "Width"=>0,
                                                    "Height"=> 0,
                                                    "Unit"=> ""
                                                ),
                                                "Comments"=>"Test"
                                              
                                              ),
                                              
                                              ),
                                           
                                          
                                            "Status"=> "Ready",
                                            "ExistingShipments"=> null,
                                            "Branch"=> "",
                                            "RouteCode"=> ""
                                            
                                        ),
                                       
                                       
                                          "Transaction"=>array(
                                          "Reference1"=>"",
                                            "Reference2"=> "",
                                            "Reference3"=> "",
                                            "Reference4"=> "",
                                            "Reference5"=> ""
                                        
                                        ),
                                        );
                                        
                                        
                                     $d=$aramex;
                                     
                                     $data = json_encode($d) ;
                                     
                                     $client = new Client([
                                     
                                      'headers' => ['Content-Type' =>'application/json','Accept'=>'application/json']
                                  
                                       ]);
                        
                                    $response = $client->post('https://ws.dev.aramex.net/ShippingAPI.V2/Shipping/Service_1_0.svc/json/CreatePickup',
                        
                                      ['body' =>$data]
                               
                                     );
                                
                                      $m = json_decode($response->getBody(), true);
                                       
                                      $order =Transaction::findOrFail($id);
                                      
                                      $order['Aramex_Guid']=$m['ProcessedPickup']['GUID'];
                                      
                                      $order['pickup']=$m['ProcessedPickup']['ID'];
                                      
                                       $aramex=array(
                          
                                           "ClientInfo"=>array(
                                            "UserName"=>$b->aramex_user,
                                            "Password"=>$b->aramex_password,
                                            "Version"=>"v1",
                                             "AccountNumber"=> $b->aramex_number,
                                             "AccountPin"=>  $b->aramex_pin,
                                             "AccountEntity"=> $b->aramex_entity,
                                             "AccountCountryCode"=> "EG",
                                             "Source"=> 24
                                    
                                       ),
                                     
                                        "Reference"=>$m['ProcessedPickup']['ID'],
                                        
                                        "Transaction"=>array(
                                            "Reference1"=> "",
                                            "Reference2"=> "",
                                            "Reference3"=> "",
                                            "Reference4"=> "",
                                            "Reference5"=> "",
                                            
                                             ),
                                           );
                                           
                                                $d=$aramex;
                                                $data = json_encode($d) ;
                                                $client = new Client([
                                                  'headers' => ['Content-Type' =>'application/json','Accept'=>'application/json']
                                      
                                              ]);
                                
                                            $response = $client->post('https://ws.dev.aramex.net/ShippingAPI.V2/Tracking/Service_1_0.svc/json/TrackPickup',
                                
                                                 ['body' =>$data]
                                            );
                
                                         $s=json_decode($response->getBody(), true);

                                         $status_aramexx=$s['LastStatus'];
                                     
                                         $order['shipmentstatus']="Aramex - $status_aramexx";
                                         
                                         $order->save();
                                         */
               
               
               }
                                        
                  
     
                     public function  aramexshipmentstatus($id,$id1){
                   
                       $order= Transaction::where('pickup',$id)->first();

                        $b = ShipmentSetting::where('business_id',$order->business_id)->first();
                      
                         $aramex=array(
                            
                           "ClientInfo"=>array(
                            "UserName"=>$b->aramex_user,
                            "Password"=>$b->aramex_password,
                            "Version"=>"v1",
                            "AccountNumber"=> $b->aramex_number,
                            "AccountPin"=>  $b->aramex_pin,
                            "AccountEntity"=> $b->aramex_entity,
                            "AccountCountryCode"=> "EG",
                            "Source"=> 24
                            
                            ),
                                     
                        "Reference"=>$id1,
                        
                        "Transaction"=>array(
                            "Reference1"=> "",
                            "Reference2"=> "",
                            "Reference3"=> "",
                            "Reference4"=> "",
                            "Reference5"=> "",
                            
                             ),
                           );
                           
                                $d=$aramex;
                                $data = json_encode($d) ;
                                $client = new Client([
                                  'headers' => ['Content-Type' =>'application/json','Accept'=>'application/json']
                      
                              ]);
                
                            $response = $client->post("$b->aramex_link/ShippingAPI.V2/Tracking/Service_1_0.svc/json/TrackPickup",
                
                                 ['body' =>$data]
                            );

                      $m = json_decode($response->getBody(), true);
                      $order =Transaction::findOrFail($id);
                      $order['shipmentstatus']=$m['LastStatus'];
                      $order->save(); 
                 
               }
              
                 
public function  Awb($id)
{
    // return 'Zayed'                  ;
    $order= Transaction::where('barcod',$id)->first();

                        $b = ShipmentSetting::where('business_id',$order->business_id)->first();
                        
                        $client = new Client([
                    
                        'headers' => ['Content-Type' =>'application/x-www-form-urlencoded']
                      
                       ]);
                
                          $response = $client->post('https://integration.mylerz.net/Token',  
                         
                           ['form_params' => [ 
                              
                                "grant_type"=>"password",
                                "username"=>$b->mylerz_user,
                                "password"=>$b->mylerz_password,
                                
                                ],
                            ]); 
                                  
                       
                       $m = json_decode($response->getBody(), true);
                       
                       $n= $m['access_token'];
                       

                         $abs=array(
                     
                            "Barcode"=>$id
                        
                            );
                        
                      $d=$abs;
                      
                      $data = json_encode($d);
                      
                      $client = new Client([
                          
                      'headers' => ['Content-Type' =>'application/json','Authorization'=>" Bearer $n"]
                     ]);
                
                     $response = $client->post('https://integration.mylerz.net/api/packages/GetAWB',
                
                          ['body' =>$data]
                     
                     );
                    
                    $m = json_decode($response->getBody(), true);
                    
                    $awbpdf= base64_decode($m['Value']);
                
                       return response()->make($awbpdf, 200, [
                           
                                'Content-type'        => 'application/pdf',
                                'Content-Disposition' => 'attachment; filename="awb.pdf"',
                                'Content-Transfer-Encoding'=>'binary',
                                'Accept-Ranges'=>'bytes'
                            ]);
                      }
                
                     public function aramex_pickup($h){
                         
                        $order= Transaction::where('pickup',$h)->first();

                        $b = ShipmentSetting::where('business_id',$order->business_id)->first();
                       
                         $aramex=array(
                            
                           "ClientInfo"=>array(
                            "UserName"=>$b->aramex_user,
                            "Password"=>$b->aramex_password,
                            "Version"=>"v1",
                            "AccountNumber"=> $b->aramex_number,
                            "AccountPin"=> $b->aramex_pin,
                            "AccountEntity"=> $b->aramex_entity,
                            "AccountCountryCode"=> "EG",
                            "Source"=> 24
                            
                            ),
                                     
                        "Reference"=>$h,
                        
                        "Transaction"=>array(
                            "Reference1"=> "",
                            "Reference2"=> "",
                            "Reference3"=> "",
                            "Reference4"=> "",
                            "Reference5"=> "",
                            
                             ),
                           );
                           
                                $d=$aramex;
                                $data = json_encode($d) ;
                                $client = new Client([
                                  'headers' => ['Content-Type' =>'application/json','Accept'=>'application/json']
                      
                              ]);
                
                            $response = $client->post("$b->aramex_link/ShippingAPI.V2/Tracking/Service_1_0.svc/json/TrackPickup",
                
                                 ['body' =>$data]
                            );

                              $m = json_decode($response->getBody(), true);
                              
                             return view('admin.shipment.aramex-pickup-trak',compact('m'));
                      
                     }
                      
                      
                        public function getapi($id) {
                    
                        
                         $order= Transaction::where('bosta_number',$id)->first();
                         
                         $b = ShipmentSetting::where('business_id',$order->business_id)->first();
                          
                            
                            $client = new Client([
                                
                                'headers' => ['Content-Type' =>'application/json','Authorization'=>$b->bosta_key]
                        
                                 ]);
                                 
                              $response = $client->get("$b->bostalink/api/v0/deliveries");
                              
                              $theresult = json_decode($response->getBody(), true);
                              
                                return view('admin.shipment.bosta-shipment',compact('theresult'));
                                
                          
                        }
                         
                         
                         
                 
                public function  fedexx($id){
                   
                     $order= Transaction::where('fedex_awb',$id)->first();

                     $b = ShipmentSetting::where('business_id',$order->business_id)->first();
                   
                    $password= md5($b->fedex_password);
                    $security_key = "$b->fedex_privatehash";
                    $keyEncrypted = strrev(md5($security_key));
                    $hashKey = trim(sha1($keyEncrypted));

                     $client = new Client([
                          
                     ]);
                
                           $response = $client->post('http://api.egyptexpress.me/api/AWBstatus',
                
                                   [
                                          'form_params' => [
                                            "accountNo"=>$b->fedex_account,
                                            "password"=>$password,
                                            "hashkey"=> $hashKey ,
                                            "SN[]" => $id
        
                                ],
                                ]);
                                                
                    
                        $m = json_decode($response->getBody(), true);

                        return view('admin.shipment.fedex_show',compact('m'));
                   }
               
             
                     public function showbosta($id)
                     {  
                        /* abdullah-karam 16-9-2021 */
                        
                        return redirect($this->getBostaAWB($id));
                        
                        /* end edit */
                        
                        
                        /*$order= Transaction::where('bosta_number',$id)->first();

                         $b = ShipmentSetting::where('business_id',$order->business_id)->first();
                         
                       
                          $client = new Client([
                    
                         'headers' => ['Content-Type' =>'application/json','Authorization'=>$b->bosta_key]
                
                               ]);
                               
                          $response = $client->get("$b->bostalink/api/v0/deliveries/".$id);
                          
                          $theresult = json_decode($response->getBody(), true);
                     
                           return view('admin.shipment.bosta_show',compact('theresult')) ;*/
                     }
                  
                 public function fastlo_show($id){
                     
                    $order= Transaction::where('fastlo_numbers',$id)->first();

                    $b = ShipmentSetting::where('business_id',$order->business_id)->first();
                   
                   
                     $j=array(
                        
                       'request'=>array(
                         "tracknumber"=>$id,
                     ),
                 );
             
                     
                $d =$j;
                
                $data = json_encode($d) ;
                
                $client = new Client([
                    
                    'headers' => ['Content-Type' =>'application/json','fastlo-api-key'=>$b->fastloapi]
                ]);
                
                $response = $client->post('https://fastlo.com/api/v1/read_shipment',
                
                        ['body' =>$data]
                ); 
                
                   $m = json_decode($response->getBody(), true);
                   
                   return view('admin.shipment.fastloshow',compact('m'));
    
             }
        
               public function   absawb(){
                
                  $b = Shipmentsetting::findOrFail(1);
                    
                   $bostaa=array(
                        
                     "UserName"=>$b->abs_user,
                     "Password"=>$b->abs_password,
                   
                    );
                 
                       $d = $bostaa ;
                       $data = json_encode($d) ;
                       $client = new Client([
                        'headers' => ['Content-Type' =>'application/json']
                      
                      ]);
                
                          $response = $client->put('http://api201.mpsegypt.com/DemoAPI/api/ClientUsers/Login',
                
                              ['body' =>$data]
                        
                      );
                      
                      $m = json_decode($response->getBody(), true);
                       
                      $tokenz=$m['AccessToken'];
                  
                      $nowtimz =date("Y-m-d");
                     
                      $d=strtotime("-1 Days");

                      $abs=array(
                        
                         "Date1"=> date("Y-m-d",$d),
                         "Date2"=> $nowtimz
                        );
                        
                           
                      $d=$abs;
                      $data = json_encode($d) ;
                      $client = new Client([
                      'headers' => ['Content-Type' =>'application/json','AccessToken'=>$tokenz]
                     ]);
                
                     $response = $client->post('http://a1.mpsegypt.com/DemoAPI/api/ClientUsers/GetAllAWBs',
                
                          ['body' =>$data]
                     
                     );
                
                   $m = json_decode($response->getBody(), true);
                   
                   return view('admin.shipment.abs_awb',compact('m'));  
                   
            }
            
            
               public function  picksshipments($id){
            
                   $order= Transaction::where('pickskey',$id)->first();
                  
                   $b = ShipmentSetting::where('business_id',$order->business_id)->first();
                    
                    $pic=$b->pickskey;
                    
                    $client = new Client([
                        
                       'headers' => ['Accept' =>'application/json','Authorization'=>"Bearer $pic"]
                                  
                   ]);
                            
                   $response = $client->get('https://pickscourier.com/api/v1/shipments');
            
                   $m = json_decode($response->getBody(), true);
                               
                  return view('admin.shipment.picks_shipment',compact('m'));  
                    
           
               }
            
                 public function  picks_shipment($id){
                   
                  $order= Transaction::where('pickskey',$id)->first();
                  
                   $b = ShipmentSetting::where('business_id',$order->business_id)->first();
                  
                   $pic=$b->pickskey;
                
                    $client = new Client([
                        
                       'headers' => ['Accept' =>'application/json','Authorization'=>"Bearer $pic"]
                                  
                   ]);
                            
                   $response = $client->get('https://pickscourier.com/api/v1/shipments/'.$id.'/tracking');
            
                   $m = json_decode($response->getBody(), true);

                  return view('admin.shipment.picks_show',compact('m')); 
                 
                 
                 }
                  
    
               
             public function  abs($id){
                 
               
                $order= Transaction::where('absnumber',$id)->first();
                
                $b = ShipmentSetting::where('business_id',$order->business_id)->first();
             

                $bostaa=array(
                        
                   "UserName"=>$b->abs_user,
                   "Password"=>$b->abs_password,
                   
                   );
                 
                       $d = $bostaa ;
                       $data = json_encode($d) ;
                       $client = new Client([
                        'headers' => ['Content-Type' =>'application/json']
                      
                      ]);
                
                          $response = $client->put('http://api201.mpsegypt.com/DemoAPI/api/ClientUsers/Login',
                
                              ['body' =>$data]
                        
                      );
                      
                       $m = json_decode($response->getBody(), true);
                       
                       $tokenz=$m['AccessToken'];
                     
                     
                      $abs=array(
                        
                      "AWBs"=>array(
                          
                          $id
                          
                          )

                        );
                        
                           
                      $d=$abs;
                      $data = json_encode($d) ;
                      $client = new Client([
                      'headers' => ['Content-Type' =>'application/json','AccessToken'=>$tokenz]
                     ]);
                
                     $response = $client->post('http://api201.mpsegypt.com/DemoAPI/api/ClientUsers/V2/GetShipmentsEx',
                
                          ['body' =>$data]
                     
                     );
                
                   $m = json_decode($response->getBody(), true);
                   
                   return view('admin.shipment.abs-show',compact('m'));  
             }
                   
             
 
                      
        public function generate_pdf($id)
        {

           
            $order= Transaction::where('fedex_awb',$id)->first();

            $b = ShipmentSetting::where('business_id',$order->business_id)->first();
            
            $password= md5('Tej@nV$Fsd');
            $security_key ="$b->fedex_privatehash";

        //DWB Serial Number
          $sn = $id;
            // dd($order);
        //encrypt security key
        $keyEncrypted = strrev(md5($security_key));

        //hash key
        $Hhash_key = trim(sha1($sn . $keyEncrypted));

        $client = new Client;

        $response = $client->post('http://api.egyptexpress.me/api/AWBpdf/',
            
                ['form_params' => [       
                    "accountNo"=>32,
                    "password"=>$password,
                    "SN"=> $sn,
                    "hashkey" => $Hhash_key]
                ]); 
        
          return $response;
  
    }
        
                      
}
