<?php
namespace JodiChandra\BridgingBpjs\Antrian;

use JodiChandra\BridgingBpjs\BpjsService;

class Antrian extends BpjsService
{
    public function tambahAntrianJKN($data = [])
    {
        $response = $this->post('antrean/add', $data);
        return json_decode($response, true);
    }

    public function updateWaktuAntrian($data = [])
    {
        $response = $this->post('antrean/updatewaktu', $data);
        return json_decode($response, true);
    }

    public function batalAntrian($data = [])
    {
        $response = $this->post('antrean/batal', $data);
        return json_decode($response, true);
    }

    

}