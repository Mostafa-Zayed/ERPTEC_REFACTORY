<?php

namespace Modules\Shop\Traits;


trait InteractsWithShopResponse
{
    public function decodeResponse($response)
    {
        $decodedResponse = json_decode($response);
        return $decodedResponse->data ?? $decodedResponse;
    }
    
    public function checkIfErrorResponse($response)
    {
        if(isset($response->error)){
            throw new \Exception("Response error {$response->error}");
        }
    }
}