<?php

namespace App\Http\Controllers;

use App\Account;

use App\AccountTransaction;
use App\TransactionPayment;
use App\Utils\TransactionUtil;
use DB;
use SoapClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AramexController extends Controller
{
    private $openSoapEnvelope;
    private $soapHeader;
    private $closeSoapEnvelope;
    
    public function __construct()
    {
        $this->openSoapEnvelope   =    '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">';
        
        $this->soapHeader         =   '<soapenv:Header><tem:AuthHeader><tem:username>1234</tem:username><tem:password>1234</tem:password></tem:AuthHeader></soapenv:Header>';
                                
        $this->closeSoapEnvelope   =   '</soapenv:Envelope>';
    }
    
    public function generateSoapRequest($soapBody)
    {
        
        return $this->openSoapEnvelope . $this->soapHeader . $soapBody . $this->closeSoapEnvelope;
    }
    
    
    public function index()
    {
        
//         $opts = array(
//     'ssl' => array(
//         'ciphers'     => 'RC4-SHA',
//         'verify_peer' => false, 
//         'verify_peer_name' => false 
//     ),
// );

// // SOAP 1.2 client
// $params = array(
//     'encoding'           => 'UTF-8',
//     'verifypeer'         => false,
//     'verifyhost'         => false,
//     'soap_version'       => SOAP_1_2,
//     'trace'              => 1,
//     'exceptions'         => 1,
//     'connection_timeout' => 180,
//     'stream_context'     => stream_context_create( $opts ),
// );
// $url = 'https://simpleeapitest.dqbroadwayinbound.com/simpleapp.aspx?WSDL';
        
//         try {
//     $client = new SoapClient( $url, $params );
// } catch ( SoapFault $fault ) {
//     echo '<br>' . $fault;
// }
        
        
        
        
        
        $Wsdl = 'https://simpleeapitest.dqbroadwayinbound.com/simpleapp.aspx';
        libxml_disable_entity_loader(false); //adding this worked for me
        $Client = new SoapClient($Wsdl);
        dd($Client);
        $soapClient = new SoapClient('https://eapi.broadwayinbound.com/BIWS.svc', array('trace' => 1));
        dd($soapClient);
        // $this->openSoapEnvelope   = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">';
        
        // $soapBody = '<soapenv:Body><tem:ShowBasics><tem:SaleTypesCode>F</tem:SaleTypesCode><tem:ShowCityCode>NYCA</tem:ShowCityCode><tem:ShowAddedDate>2010-01-01</tem:ShowAddedDate></tem:ShowBasics></soapenv:Body>';
        // $this->closeSoapEnvelope   =   '</soap:Envelope>';
        
        // $xmlRequest = $this->openSoapEnvelope . $this->soapHeader . $soapBody . $this->closeSoapEnvelope;
        // // dd($xmlRequest);
        // try{
        //     $client = new Client();
        //     $options = [
        //         'body'    => $xmlRequest,
        //         'headers' => [
        //             "Content-Type" => "text/xml; charset=utf-8",
        //             "accept" => "*/*",
        //             "accept-encoding" => "gzip, deflate, br",
        //             "SOAPAction" => 'ShowBasics'
        //         ]
            
        //     ];
            
        //     $res = $client->request(
        //         'POST',
        //         'https://eapi.broadwayinbound.com/BIWS.svc',
        //         $options
        //     );
            
            
        //     $xml = $res->getBody()->getContents();
        //     dd($xml);
            
    
        // }catch(GuzzleException $e) {
        //     dd($e,'error');
        // }
        
    }
    
    public function sendRequest($orderData)
    {
        
        try{
            
            $client = new Client(['base_uri' => $this->baseUrl]);
            // addship   addShipMps
            $response = $client->post('addShipMps',[
                'headers' => ['Content-Type' =>'application/json'],
                'body' => json_encode($orderData)
            ]);
            
            $responseData = json_decode($response->getBody(),true);
            
            if(strpos($responseData,'Failed ::') === 0){
                return [
                    'status' => false,
                    'errors' => $responseData
                ];
            } else {
                return [
                    'status' => true,
                    'errors' => null,
                    'smsa_track' => $responseData
                ];
            }
            
            // //290340902484
            // dd($responseData);
            
        } catch(GuzzleException $e) {
            
            $exception = (string) $e->getResponse()->getBody();
            
            $exception = json_decode($exception);
            // dd($exception);
            return [
                'status' => false,
                'error' => $exception
            ];
            dd($exception);
        }
        
    }
}