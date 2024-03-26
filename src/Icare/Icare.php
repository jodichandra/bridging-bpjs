<?php
namespace JodiChandra\Bridging\Bpjs\Icare;

use JodiChandra\Bridging\Bpjs\BpjsService;

class Icare extends BpjsService
{
    public function validasiGetToken($data = [])
    {
        $header = ['Content-Type' => 'application/json; charset=utf-8'];
        $response = $this->post('api/rs/validate', $data, $header);
        return json_decode($response, true);
    }
    
}
