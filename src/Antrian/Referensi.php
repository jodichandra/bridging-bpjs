<?php
namespace JodiChandra\Bridging\Bpjs\Antrian;

use JodiChandra\Bridging\Bpjs\BpjsService;

class Referensi extends BpjsService
{
    public function getPoli()
    {
        $response = $this->get('ref/poli');
        return json_decode($response, true);
    }

    public function getDokter()
    {
        $response = $this->get('ref/dokter');
        return json_decode($response, true);
    }

    public function getJadwalDokter($kodePoli, $tanggalPraktek)
    {
        $response = $this->get('jadwaldokter/kodepoli/' . $kodePoli . '/tanggal/' . $tanggalPraktek);
        return json_decode($response, true);
    }

    public function updateJadwalHfis($dataJadwal)
    {
        $response = $this->post('jadwaldokter/updatejadwaldokter', $dataJadwal);
        return json_decode($response, true);
    }

    

}