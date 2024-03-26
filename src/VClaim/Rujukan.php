<?php
namespace JodiChandra\BridgingBpjs\VClaim;

use JodiChandra\BridgingBpjs\BpjsService;

class Rujukan extends BpjsService
{

    public function insertRujukan($data = [])
    {
        $response = $this->post('Rujukan/2.0/insert', $data);
        return json_decode($response, true);
    }
    public function updateRujukan($data = [])
    {
        $response = $this->put('Rujukan/2.0/Update', $data);
        return json_decode($response, true);
    }
    public function deleteRujukan($data = [])
    {
        $response = $this->delete('Rujukan/delete', $data);
        return json_decode($response, true);
    }

    public function cariByNoRujukan($nomor, $faskes)
    {
        if ($faskes == 'FKTP' || $faskes == 1) {
            $url = 'Rujukan/'.$nomor;
        } else {
            $url = 'Rujukan/RS/'.$nomor;
        }
        $response = $this->get($url);
        return json_decode($response, true);
    }

    public function cariByNoKartu($searchBy, $keyword, $multi = false)
    {
        $record = $multi ? 'List/' : '';
        if ($searchBy == 'FKTP' || $searchBy == 1) {
            $url = 'Rujukan/'.$record.'Peserta/'.$keyword;
        } else {
            $url = 'Rujukan/RS/'.$record.'Peserta/'.$keyword;
        }
        $response = $this->get($url);
        return json_decode($response, true);
    }

    public function cariByTglRujukan($searchBy, $keyword)
    {
        if ($searchBy == 'FKTP') {
            $url = 'Rujukan/List/Peserta/'.$keyword;
        } else {
            $url = 'Rujukan/RS/TglRujukan/'.$keyword;
        }
        $response = $this->get($url);
        return json_decode($response, true);
    }

    public function jumlahKunjungan($jenisRujukan, $nomorRujukan)
    {
      
        $response = $this->get('Rujukan/JumlahSEP/'.$jenisRujukan.'/'.$nomorRujukan);
        return json_decode($response, true);
    }

    // List Rujukan Keluar RS
    public function listRujukanKeluar($tglMulai, $tglAkhir)
    {
        $response = $this->get('Rujukan/Keluar/List/tglMulai/'.$tglMulai.'/tglAkhir/'.$tglAkhir);
        return json_decode($response, true);
    }

    public function cariRujukanKeluar($nomorRujukan)
    {
        $response = $this->get('Rujukan/Keluar/'.$nomorRujukan);
        return json_decode($response, true);
    }

    public function listSpesialistik($kodePPK, $tglRujukan)
    {
        $response = $this->get('Rujukan/ListSpesialistik/PPKRujukan/'.$kodePPK.'/TglRujukan/'.$tglRujukan);
        return json_decode($response, true);
    }

    // Rujukan Khusus
    public function insertRujukanKhusus($data = [])
    {
        $response = $this->post('Rujukan/Khusus/insert', $data);
        return json_decode($response, true);
    }

    public function deleteRujukanKhusus($data = [])
    {
        $response = $this->post('Rujukan/Khusus/delete', $data);
        return json_decode($response, true);
    }

    public function listRujukanKhusus($bulan, $tahun)
    {
        $response = $this->get('Rujukan/Khusus/List/Bulan/'.$bulan.'/Tahun/'.$tahun);
        return json_decode($response, true);
    }

}