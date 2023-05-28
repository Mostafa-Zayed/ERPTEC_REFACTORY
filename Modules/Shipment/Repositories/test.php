<?php

// dd($settings);
        // if ($this->env == 'test') {
            
        //     return [
        //         'bizContent' => [
        //             "customerCode" => "J0086024049", 
        //             "digest" => "6uaiZR8B88EcuhMa62yaDw==", 
        //             "network" => "null", 
        //             "txlogisticId" => "100203001239", 
        //             "orderType" =>  2,
        //             "expressType" =>  "standard",
        //             "serviceType" =>  "01",
        //             "deliveryType" =>  "04",
        //             "operateType" => "1",
        //             "sender" => [
        //                 "name" =>  "الجيزة",
        //                 "company" => "Willson",
        //                 "postCode" => "518000",
        //                 "mailBox" => "ant_li@qq.com",
        //                 "mobile" => "12345678909",
        //                 "phone" => "",
        //                 "countryCode" => "EG",
        //                 "prov" => "الجيزة",
        //                 "city" => "الجيزة",
        //                 "street" => "Cairo",
        //                 "address" => "الجيزة",
        //             ],
        //             "receiver" => [
        //                 "name" => "الجيزة",
        //                 "company" => "Cairo",
        //                 "postCode" =>  "000000",
        //                 "mailBox" =>  "ant_li@qq.com",
        //                 "mobile" => "12345678909",
        //                 "phone" => "",
        //                 "countryCode" => "EG",
        //                 "prov" => "الجيزة",
        //                 "city" => "الجيزة",
        //                 "street" => "Cairo",
        //                 "address" => "الجيزة"
        //             ],
        //             "sendStartTime" => "2019-08-06 15:00:00",
        //             "sendEndTime" => "2019-08-06 15:30:00",
        //             "goodsType" => "ITN4",
        //             "length" => 50,
        //             "width" => 50,
        //             "height" => 1,
        //             "volume" => 250,
        //             "weight" => 1,
        //             "totalQuantity" => 1,
        //             "itemsValue" => "200",
        //             "priceCurrency" => "EGP",
        //             "payType" => "PP_PM",
        //             "offerFee" => "200000",
        //             "remark" => "im",
        //             "createOrderTime"=> "2019-08-06 15:30:00"
        //         ]
        //     ];    
        // }else {
        
                
        
        
        
        //     return [
        //     'bizContent' => [
        //         'customerCode' => $settings['customerCode'],
        //         'digest' => $this->getContentDigest($settings['customerCode'],$settings['password'],$this->privateKey),
        //         'network' => '',
        //         'txlogisticId' => $order->id,
        //         'ExpressType' => 'EZ',
        //         'orderType' => 2,
        //         'serviceType' => '02',
        //         'deliveryType' => '04',
        //         'PayType' => null, //'FOD',
        //         'sender' => [
        //             'name'     => $settings['name'],
        //             'company'  => null,
        //             'postCode' => null,
        //             'mailBox' => null, //$settings['mailBox'],
        //             'mobile' => $settings['mobile'],
        //             'phone' => $settings['phone'],
        //             'countryCode' => $settings['countryCode'],
        //             'prov' => $settings['prov'],
        //             'city' => $settings['city'],
        //             'street' => $settings['street'],
        //             'building' => null,
        //             'floor' => null,
        //             'areaCode' => null,
        //             'flats' =>  null,
        //             'address' => null,
        //             'area' => null,
        //         ],
        //         'receiver' => [
        //             'name' => $contact->first_name . ' ' . $contact->last_name ,
        //             'company' => null,
        //             'postCode' => null,
        //             'mailBox' => null, //$contact->email,
        //             'mobile' => $contact->mobile,
        //             'phone' => $contact->mobile,
        //             'countryCode' =>  'EGY',
        //             'prov' => 'test',
        //             'city' => 'city',
        //             'district' => 'district',
        //             'street' => 'street',
        //             'area'=>  null,
        //             'building' =>  null,
        //             'floor' =>  null,
        //             'flats' =>  null,
        //             'address' => $address->address,
        //             'areaCode' => null,
        //             'lng' => null,
        //             'lat' => null
        //         ],
        //         'sendStartTime' => null,
        //         'sendEndTime' => null,
        //         'goodsType' => 'ITN1',
        //         'length' => null,
        //         'width' => null,
        //         'height' => null,
        //         'weight' => 5.02,
        //         'totalQuantity' => null, // '1',
        //         'itemsValue' => null , 
        //         'priceCurrency' => null,
        //         'offerFee' => null,
        //         'remark' => null,
        //         'items' => [
        //         ],
        //         'customsInfo' => [
        //         ],
        //         'operateType' => 1,
                
        //     ]
            
        // ];
        // }
               // dd(json_decode($result,true));
        // if()
//         array:3 [
//   "code" => "1"
//   "msg" => "success"
//   "data" => array:4 [
//     "txlogisticId" => "373228"
//     "billCode" => "UEG000000290520"
//     "sortingCode" => ",,"
//     "createOrderTime" => "2022-07-20 03:36:00"
//   ]
// ]
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        // $url = 'order/addOrder?uuid=b237d3b7b29b454ba92de4356ebb28b1';
        // // dd($inputs);
        // $head_dagest = $this->get_header_digest($inputs,$this->privateKey);
        // // dd($head_dagest);
        // if(! empty($inputs)) {
        //     try{
        //         // dd($inputs);
                
        //         $postdata = http_build_query($inputs);
        //         // dd($postdata);
        //         $options = array(
        //             'http' => array(
        //             'method' => 'POST',
        //             'header' =>
        //                 array(
        //                     'Content-type: application/x-www-form-urlencoded',
        //                     'apiAccount:' . $this->apiAccount,
        //                     'digest:' . $head_dagest,
        //                     'timestamp: 1638428570653'),
        //                     'content' => $postdata,
        //                     'timeout' => 15 * 60 // 超时时间（单位:s）
        //                 )
        //         );
    
        //         $context = stream_context_create($options);

        //         $result = file_get_contents($this->baseUrl . $url, false, $context);

        //         dd($result);
        //         dd($postdata);
        //         // $client = new Client(['base_uri' => $this->baseUrl]);
                
        //         // $response = $client->post('order/addOrder?uuid=b237d3b7b29b454ba92de4356ebb28b1',[
        //         //     'headers' => [
        //         //         'Content-Type' =>'application/json',
        //         //         'apiAccount' => $this->apiAccount,
        //         //         'digest' => $this->getHeaderDigest($inputs['bizContent'],$this->privateKey),
        //         //         'timestamp' => floor(microtime(true) * 1000)
        //         //     ],
                    
        //         //     'body' => json_encode($inputs)
        //         // ]);
                
        //         // $responseData = json_decode($response->getBody(),true);
        //         // dd($responseData);
        //     } catch(GuzzleException $e) {
        //         dd($e);
        //     }
        // }
        