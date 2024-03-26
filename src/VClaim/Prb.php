<?php
namespace Bridging\Bpjs\VClaim;

use Bridging\Bpjs\BpjsService;

class Prb extends BpjsService
{
    public function insertPRB($data = [])
    {
        $response = $this->post('PRB/insert', $data);
        return json_decode($response, true);
    }
    public function updatePRB($data = [])
    {
        $response = $this->put('PRB/Update', $data);
        return json_decode($response, true);
    }

    public function dataListPRB($tglAwal, $tglAkhir)
    {
        $response = $this->get('prb/tglMulai/'.$tglAwal.'/tglAkhir/'.$tglAkhir);
        return json_decode($response, true);
    }

    public function cariDataPRB($noSRB, $noSep)
    {
        $response = $this->get('prb/'.$noSRB.'/nosep/'.$noSep);
        return json_decode($response, true);
    }

    public function hapusDataPRB($data = [])
    {
        $response = $this->delete('PRB/Delete', $data);
        return json_decode($response, true);
    }

    

}