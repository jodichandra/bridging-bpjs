<?php
namespace JodiChandra\BridgingBpjs\Icare;

use JodiChandra\BridgingBpjs\BpjsService;

class Icare extends BpjsService
{
    public function validasiGetToken($data = [])
    {
        $header = ['Content-Type' => 'application/json; charset=utf-8'];
        $response = $this->post('api/rs/validate', $data, $header);
        return json_decode($response, true);
    }
    
}
