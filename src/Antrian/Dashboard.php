<?php
namespace JodiChandra\Bridging\Bpjs\Antrian;

use JodiChandra\Bridging\Bpjs\BpjsService;

class Dashboard extends BpjsService
{
    public function getDashboardTanggal($tanggal, $waktu)
    {
        $response = $this->get('dashboard/waktutunggu/tanggal/'.$tanggal.'/waktu/'.$waktu);
        return json_decode($response, true);
    }

    public function getDashboardBulan($bulan, $tahun, $waktu)
    {
        $response = $this->get('dashboard/waktutunggu/bulan/'.$bulan.'/tahun/'.$tahun.'/waktu/'.$waktu);
        return json_decode($response, true);
    }

    public function getListWaktu($data = [])
    {
        $response = $this->post('antrean/getlisttask', $data);
        return json_decode($response, true);
    }

}