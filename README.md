## Personal Convert

Tool sederhana untuk keperluan di kantor kami.

Fitur:
- convert file CSV ke bentuk Seeder laravel
- generate migrate, controller, interface, repository, request, model for laravel 4.2 (code sesuai standar di kantor)
bisa generate di halaman ataupun langsung ke folder aplikasi
- generate fpdf (under maintenance)

Info:
- untuk contoh template formulir yang digunakan ada di `test-dokumen.csv`
- pastikan dokumen yang di generate hanya yang tipenya `CSV`
- jika dokumen masih bertipe `excel`, silahkan disave as `CSV`
- untuk menjalankan tool ini silahkan setting konfigurasi di server local

Atau bisa menggunakan cmd tanpa harus setting konfigurasi server local:
- `cd personal-convert`
- `php -S localhost:9090`
- `buka browser localhost:9090`

Jika muncul pesan failed to open stream: Permission denied
ketikkan `sudo chmod -R 777 destination_folder`

Contact Person: 
- rohmadsasmito@gmail.com
- [Facebook](https://facebook.com/rohmad.sasmito)

