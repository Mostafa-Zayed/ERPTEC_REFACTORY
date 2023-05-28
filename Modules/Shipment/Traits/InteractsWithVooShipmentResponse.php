<?php 

namespace Modules\Shipment\Traits;

trait InteractsWithVooShipmentResponse
{
    public function decodeResponse($response)
    {
        $decodedResponse = json_decode($response,true);
        return $decodedResponse->data ?? $decodedResponse;
    }
    
    public function checkIfErrorResponse($response)
    {
        if(isset($response->error)){
            throw new \Exception("Error {$response->error}");
        }
    }
}