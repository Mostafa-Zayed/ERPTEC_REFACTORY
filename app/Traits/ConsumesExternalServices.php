<?php

namespace App\Traits;

use GuzzleHttp\Client;

trait ConsumesExternalServices
{
    
    /**
     * send a request to any service
     * 
     * @param $method string
     * @param $requestUrl string
     * @param $queryParams array
     * @param $formParams array
     * @param $headers array
     * @param $isJsonRequest bool
     * @param $hasFiles bool
     * @return stdClass|string
     */
    public function makeRequest($method, $requestUrl, $queryParams = [], $formParams = [], $headers = [], $isJsonRequest = false, $hasFiles = false)    
    {
        
        $client = new Client([
            'base_uri' => $this->base_url,
        ]);
        
        // $testurl = self::generateRequestUrl($requestUrl);
        
        if(method_exists($this,'resolveAuthorization')){
            $this->resolveAuthorization($queryParams,$formParams,$headers);    
        }
        
        
        $response = $client->request($method, self::generateApiEndPoint($requestUrl),[
            'headers' => $headers,
            'query' => $queryParams,
            $isJsonRequest ? 'json' : 'form_params' => $formParams
        ]);
        
        
        $response = $response->getBody()->getContents();
        
        if(method_exists($this,'decodeResponse')){
            $response = $this->decodeResponse($response);
        }
        
        if(method_exists($this,'checkIfErrorResponse')){
            $this->checkIfErrorResponse($response);
        }
        
        return $response;
    }
    
    private function generateApiEndPoint(&$requestUrl)
    {
        return $this->apiVersion ? $this->apiVersion . $requestUrl :  $requestUrl;
        
        if(! empty($this->apiVersion)){
            return $this->apiVersion . $requestUrl;
        }
        
        return $requestUrl;
    }
    
    // public static function generateRequestUrl(&$requestUrl)
    // {
    //     return !empty(self::PREFIXURL) ? (!empty(self::APIVERSION) ? self::PREFIXURL . self::APIVERSION . $requestUrl : self::PREFIXURL . $requestUrl)  : $requestUrl;
    // }
}