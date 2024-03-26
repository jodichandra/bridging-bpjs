<?php
namespace Bridging\Bpjs;

use GuzzleHttp\Client;
use LZCompressor\LZString;

class BpjsService{

    /**
     * Guzzle HTTP Client object
     * @var \GuzzleHttp\Client
     */
    private $clients;

    /**
     * LZCompressor
     * @var \LZCompressor\LZString
     */
    private $decompress;

    /**
     * Request headers
     * @var array
     */
    private $headers;

    /**
     * X-cons-id header value
     * @var int
     */
    private $cons_id;

    /**
     * X-Timestamp header value
     * @var string
     */
    private $timestamp;

    /**
     * X-Signature header value
     * @var string
     */
    private $signature;

    /**
     * @var string
     */
    private $secret_key;

    /**
     * @var string
     */
    private $base_url;

    /**
     * @var string
     */
    private $service_name;

    /**
     * @var string
     */
    private $user_key;

    public function __construct($configurations)
    {
        $this->clients = new Client([
            'verify' => false
        ]);
        

		$this->decompress = new \LZCompressor\LZString;

        foreach ($configurations as $key => $val){
            if (property_exists($this, $key)) {
                $this->$key = $val;
            }
        }

        //set X-Timestamp, X-Signature, and finally the headers
        $this->setTimestamp()->setSignature()->setHeaders();
    }

    protected function setHeaders()
    {
        $this->headers = [
            'X-cons-id' => $this->cons_id,
            'X-Timestamp' => $this->timestamp,
            'X-Signature' => $this->signature,
            'user_key' => $this->user_key
        ];
        return $this;
    }

    protected function setTimestamp()
    {
        $dateTime = new \DateTime('now', new \DateTimeZone('UTC'));
        $this->timestamp = (string)$dateTime->getTimestamp();
        return $this;
    }

    protected function setSignature()
    {
        $data = $this->cons_id . '&' . $this->timestamp;
        $signature = hash_hmac('sha256', $data, $this->secret_key, true);
        $encodedSignature = base64_encode($signature);
        $this->signature = $encodedSignature;
        return $this;
    }

    protected function decompresString($string){

        if (is_array($string)) {
            return json_encode($string);
        }

        if ($string === null) {
            return "";
        }
        if ($string === "") {
            return null;
        }
        
        $key = $this->cons_id . '' . $this->secret_key . '' . $this->timestamp;
        $encrypt_method = 'AES-256-CBC'; 
        $key_hash = hex2bin(hash('sha256', $key)); 
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16); 
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv); 

        return $this->decompress->decompressFromEncodedURIComponent($output);
    }

    protected function stringDecrypt($string)
    {
        if (is_array($string)) {
            return json_decode($string);
        }

        $key = $this->cons_id . '' . $this->secret_key . '' . $this->timestamp;
        $encrypt_method = 'AES-256-CBC'; 
        $key_hash = hex2bin(hash('sha256', $key)); 
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16); 
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv); 
        return $output; 
    }

    protected function change_key( $array, $old_key, $new_key ) {

        if( ! array_key_exists( $old_key, $array ) )
            return $array;

        $keys = array_keys( $array );
        $keys[ array_search( $old_key, $keys ) ] = $new_key;

        return array_combine( $keys, $array );
    }

    protected function mergeResponse($response) {


        $responseDecode = json_decode($response, true);
        if (!$responseDecode) {
            $return = [
                'metadata' => [
                    'code' => 201,
                    'message' => $response,
                ],
                'response' => null
            ];
            return  json_encode($return);
        }

        if (array_key_exists('response', $responseDecode)) 
        {
            $responseDecrypt = $this->decompresString($responseDecode['response']);
            $responseDecrypt = json_decode($responseDecrypt, true);
            $responseDecode['response'] = $responseDecrypt;
        }
        else
        {
            $responseDecode['response'] = null;
        }
        $responseDecode = $this->change_key($responseDecode, 'metaData', 'metadata');
        return  json_encode($responseDecode);
    }

    protected function exceptionResponse($message) {
        $response = [
            "metadata" => [
                "code" => 201,
                "message" => $message
            ],
            "response" => null,
        ];
        return  json_encode($response);
        exit();
    }

    protected function get($feature)
    {
        $this->headers['Content-Type'] = 'application/json; charset=utf-8';
        try {
            
            $response = $this->clients->request(
                'GET',
                $this->base_url . '/' . $this->service_name . '/' . $feature,
                [
                    'headers' => $this->headers
                ]
            )->getBody()->getContents();
            if ($response) {
                $response =  $this->mergeResponse($response);
            }
            
            return $response;

        } catch (\Exception $e) {

            if ($e->getMessage()) {
                $response =  $this->exceptionResponse($e->getMessage());
                return $response;
            }

            if ($e->getResponse() == null) {
                $response =  $this->exceptionResponse($response->getMessage());
                return $response;
            }
        }
        return $response;
    }

    protected function post($feature, $data = [], $headers = [])
    {
        $this->headers['Content-Type'] = 'application/x-www-form-urlencoded';
        if(!empty($headers)){
            $this->headers = array_merge($this->headers,$headers);
        }
        try {
            $response = $this->clients->request(
                'POST',
                $this->base_url . '/' . $this->service_name . '/' . $feature,
                [
                    'headers' => $this->headers,
                    'json' => $data,
                ]
            )->getBody()->getContents();

            if ($response) {
                $response =  $this->mergeResponse($response);
            }

        } catch (\Exception $e) {
           if ($e->getMessage()) {
                $response =  $this->exceptionResponse($e->getMessage());
                return $response;
            }

            if ($e->getResponse() == null) {
                $response =  $this->exceptionResponse($response->getMessage());
                return $response;
            }
        }
        return $response;
    }

    protected function put($feature, $data = [])
    {
        $this->headers['Content-Type'] = 'application/x-www-form-urlencoded';
        try {
            $response = $this->clients->request(
                'PUT',
                $this->base_url . '/' . $this->service_name . '/' . $feature,
                [
                    'headers' => $this->headers,
                    'json' => $data,
                ]
            )->getBody()->getContents();

            if ($response) {
                $response =  $this->mergeResponse($response);
            }

        } catch (\Exception $e) {

            if ($e->getMessage()) {
                $response =  $this->exceptionResponse($e->getMessage());
                return $response;
            }

            if ($e->getResponse() == null) {
                $response =  $this->exceptionResponse($response->getMessage());
                return $response;
            }
        }
        return $response;
    }


    protected function delete($feature, $data = [])
    {
        $this->headers['Content-Type'] = 'application/x-www-form-urlencoded';
        try {
            $response = $this->clients->request(
                'DELETE',
                $this->base_url . '/' . $this->service_name . '/' . $feature,
                [
                    'headers' => $this->headers,
                    'json' => $data,
                ]
            )->getBody()->getContents();

            if ($response) {
                $response =  $this->mergeResponse($response);
            }

        } catch (\Exception $e) {

            if ($e->getMessage()) {
                $response =  $this->exceptionResponse($e->getMessage());
                return $response;
            }

            if ($e->getResponse() == null) {
                $response =  $this->exceptionResponse($response->getMessage());
                return $response;
            }
        }
        return $response;
    }

}