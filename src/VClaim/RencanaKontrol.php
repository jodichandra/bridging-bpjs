<?php
namespace JodiChandra\BridgingBpjs\VClaim;
use JodiChandra\BridgingBpjs\BpjsService;

class RencanaKontrol extends BpjsService
{
    /**
     * Rencana Kontrol
     */
    public function insertKontrol($data = [])
    {
        $response = $this->post('RencanaKontrol/insert', $data);
        return json_decode($response, true);
    }
    public function updateKontrol($data = [])
    {
        $response = $this->put('RencanaKontrol/Update', $data);
        return json_decode($response, true);
    }
    public function deleteKontrol($data = [])
    {
        $response = $this->delete('RencanaKontrol/Delete', $data);
        return json_decode($response, true);
    }

    /**
     * Surat Perintah Rawat Inap (SPRI)
     */
    public function insertSPRI($data = [])
    {
        $response = $this->post('RencanaKontrol/InsertSPRI', $data);
        return json_decode($response, true);
    }
    public function updateSPRI($data = [])
    {
        $response = $this->put('RencanaKontrol/UpdateSPRI', $data);
        return json_decode($response, true);
    }
    

    public function cariSEPKontrol($noSep)
    {
        $response = $this->get('RencanaKontrol/nosep/'.$noSep);
        return json_decode($response, true);
    }

    public function cariNomorKontrol($noSuratKontrol)
    {
        $response = $this->get('RencanaKontrol/noSuratKontrol/'.$noSuratKontrol);
        return json_decode($response, true);
    }

    public function cariNomorKontrolByNoka($bulan, $tahun, $noKa, $filter)
    {
        $response = $this->get('RencanaKontrol/ListRencanaKontrol/Bulan/'.$bulan.'/Tahun/'.$tahun.'/Nokartu/'.$noKa.'/filter/'.$filter);
        return json_decode($response, true);
    }
    
    public function listRencanaKontrol($tglAwal, $tglAkhir, $filter)
    {
        $response = $this->get('RencanaKontrol/ListRencanaKontrol/tglAwal/'.$tglAwal.'/tglAkhir/'.$tglAkhir.'/filter/'.$filter);
        return json_decode($response, true);
    }
    
    public function listPoliKontrol($JnsKontrol, $nomor, $TglRencanaKontrol)
    {
        $response = $this->get('RencanaKontrol/ListSpesialistik/JnsKontrol/'.$JnsKontrol.'/nomor/'.$nomor.'/TglRencanaKontrol/'.$TglRencanaKontrol);
        return json_decode($response, true);
    }
    
    public function listJadwalDokter($JnsKontrol, $KdPoli, $TglRencanaKontrol)
    {
        $response = $this->get('RencanaKontrol/JadwalPraktekDokter/JnsKontrol/'.$JnsKontrol.'/KdPoli/'.$KdPoli.'/TglRencanaKontrol/'.$TglRencanaKontrol);
        return json_decode($response, true);
    }
}