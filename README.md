# Bridging BPJS

## Deskripsi
Bridging BPJS adalah class PHP yang menghubungkan aplikasi Anda dengan berbagai aplikasi BPJS Kesehatan, termasuk:
- JKNMobile
- VClaim
- Icare
- Aplicares

Class ini memudahkan Anda untuk:
- Mengirim dan menerima data dari aplikasi BPJS
- Memproses klaim BPJS
- Mendapatkan informasi peserta BPJS
- Dan banyak lagi

## Persyaratan
- Sudah terdaftar dan memimiliki ID untuk akses API BPJS
- PHP v7 ke atas
- Library CI Rest Server dari [Chris Kacerguis](https://github.com/chriskacerguis/codeigniter-restserver)
- Library LZ-String dari [nullpunkt/lz-string-php](https://pieroxy.net/blog/pages/lz-string/index.html)

## Cara Penggunaan
1. Instal library CI Rest Server dan LZ-String.
2. Download atau clone aplikasi.

## Contoh Penggunaan
Berikut adalah contoh penggunaan class BridgingBPJS untuk mendapatkan informasi peserta BPJS:

```php
require_once 'vendor/autoload.php';
$key = [
        'cons_id' => cons_id,
        'secret_key' => 'secret_key',
        'user_key' => 'user_key',
        'base_url' => 'https://apijkn-dev.bpjs-kesehatan.go.id',
        'service_name' => 'vclaim-rest-dev',
    ];
$bpjs = new \Bridging\Bpjs\VClaim\Peserta($key);

$result = $bpjs->getByNoKartu('no_kartu_bpjs', date('Y-m-d'));
print("<pre>".print_r($result,true)."</pre>");
```

## Dokumentasi
Dokumentasi lengkap API BPJS dapat ditemukan di [sini](https://trustmark.bpjs-kesehatan.go.id/trust-mark/portal.html).

## Kontribusi
Anda dapat berkontribusi pada pengembangan class BridgingBPJS dengan:
- Melaporkan bug di disini.
- Mengirimkan pull request di disini.
- Membuka issue disini

## Lisensi
Class BridgingBPJS dilisensikan di bawah lisensi MIT.

## Dokumentasi BPJS
Jika Anda membutuhkan bantuan dalam menggunakan class BridgingBPJS, Anda dapat:
- Membaca dokumentasi di [sini](https://trustmark.bpjs-kesehatan.go.id/trust-mark/portal.html).
- Bergabung dengan grup Bridging BPJS

## Support dan Donasi
Jika Anda merasa libary ini bermanfaat, Anda dapat memberikan support dan dukungan pengembangan melalui:
- Saweria [sini](https://saweria.co/jodichandra).
- Bank Jago : 101632280491
- Bank BNI  : 1792209093
- Bank BSI  : 7222068325
