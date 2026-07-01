# 🦐 Sistem Pemberi Pakan Udang Otomatis Berbasis IoT

## Deskripsi
Sistem Pemberi Pakan Udang Otomatis merupakan prototype berbasis Internet of Things (IoT) yang dirancang untuk membantu petambak dalam memberikan pakan udang secara otomatis berdasarkan umur udang dan suhu air.

Sistem menggunakan mikrokontroler NodeMCU ESP8266 yang terhubung dengan sensor suhu DS18B20, sensor berat Load Cell HX711, motor servo, dan NTP Client untuk sinkronisasi waktu jadwal pemberian pakan.

Metode yang digunakan dalam pengambilan keputusan adalah Logika Fuzzy Sugeno sehingga jumlah pakan yang diberikan dapat menyesuaikan kondisi suhu air dan umur udang.

---

## Fitur Utama

- Monitoring suhu air secara realtime via sensor DS18B20.
- Penjadwalan pemberian pakan otomatis berbasis NTP (sinkronisasi waktu internet).
- Perhitungan jumlah pakan menggunakan Logika Fuzzy Sugeno.
- Monitoring berat pakan menggunakan Load Cell HX711.
- Dashboard berbasis web (CodeIgniter + MySQL).
- Pengiriman data suhu dan berat ke server via HTTP.
- Monitoring dari jaringan lokal maupun internet menggunakan NodeMCU ESP8266.

---

## Teknologi yang Digunakan

### Hardware
- NodeMCU ESP8266 (chip FTDI FT232)
- Sensor Suhu DS18B20
- Sensor Load Cell + Modul HX711
- Motor Servo x2 (Penampung & Penimbang)
- LCD 16x2 I2C (alamat 0x27)
- Power Supply 5V

### Software
- Arduino IDE 2.x
- PHP CodeIgniter 3
- MySQL
- XAMPP (Apache + MySQL)
- HTML5, CSS3, JavaScript, Bootstrap

---

## Arsitektur Sistem

```
Sensor Suhu DS18B20
        |
        v
   NodeMCU ESP8266  <------>  Server Web (CodeIgniter)
        |                          |
        v                          v
  Fuzzy Sugeno               Database MySQL
        |                          |
        v                          v
Perhitungan Jumlah Pakan     Dashboard Web
        |
        v
    Motor Servo
        |
        v
   Load Cell HX711
```

---

## Instalasi

### 1. Install Driver NodeMCU

NodeMCU ESP8266 pada project ini menggunakan chip **FTDI FT232**. Download dan install driver berikut:

- Buka: https://ftdichip.com/drivers/vcp-drivers/
- Klik **"Click here to download the Windows 10, Windows 11 driver installer (setup executable)"**
- Jalankan installer sebagai **Run as Administrator**
- Setelah install, cabut dan colok ulang kabel USB NodeMCU
- Cek Device Manager → **Ports (COM & LPT)** → harus muncul **USB Serial Port (COMx)**

> **Catatan:** Jika NodeMCU menggunakan chip CH340, download driver di https://www.wch-ic.com/downloads/CH341SER_EXE.html. Jika menggunakan CP2102, download di https://www.silabs.com/developers/usb-to-uart-bridge-vcp-drivers

---

### 2. Install Arduino IDE dan Board ESP8266

1. Download Arduino IDE di https://www.arduino.cc/en/software
2. Buka Arduino IDE → **File → Preferences**
3. Tambahkan URL berikut di *Additional Board Manager URLs*:

```
http://arduino.esp8266.com/stable/package_esp8266com_index.json
```

4. Klik OK
5. Buka **Tools → Board → Boards Manager**
6. Cari `esp8266` → klik **Install**
7. Setelah selesai, pilih board: **Tools → Board → NodeMCU 1.0 (ESP-12E Module)**
8. Pilih port: **Tools → Port → COMx** (sesuai yang muncul di Device Manager)

---

### 3. Install Library Arduino

Buka **Sketch → Include Library → Manage Libraries**, install library berikut satu per satu:

| Library | Author | Keterangan |
|---|---|---|
| LiquidCrystal I2C | Frank de Brabander | Untuk LCD 16x2 I2C |
| HX711_ADC | Olav Kallhovd | Untuk sensor berat |
| ArduinoJson | Benoit Blanchon | Untuk parsing JSON |
| DallasTemperature | Miles Burton | Untuk sensor DS18B20 |
| OneWire | Paul Stoffregen | Dependency DS18B20 |
| NTPClient | Fabrice Weinberg | Untuk sinkronisasi waktu |
| TimeLib | Paul Stoffregen | Untuk format tanggal/waktu |

> **Catatan:** Library Servo dan ESP8266WiFi sudah termasuk dalam paket board ESP8266, tidak perlu install manual.

---

### 4. Konfigurasi Kode Arduino

Buka file `kodefinalmaret.ino`, sesuaikan bagian berikut:

```cpp
// Ganti dengan nama dan password WiFi yang digunakan
const char* ssid = "NAMA_WIFI";
const char* password = "PASSWORD_WIFI";

// Ganti dengan IP laptop/server yang menjalankan XAMPP
const char* serverURL = "http://IP_SERVER/iot/Jadwal/getFuzzyPakan";
```

Untuk mengetahui IP server, buka CMD dan ketik `ipconfig`, cari **IPv4 Address**.

---

### 5. Upload Program ke NodeMCU

1. Colok NodeMCU ke laptop via kabel USB data
2. Pastikan port COMx sudah terpilih di **Tools → Port**
3. Klik tombol **Upload (→)**
4. Tunggu hingga muncul pesan `Hard resetting via RTS pin...`
5. Buka **Tools → Serial Monitor**, set baudrate ke **9600**
6. Pantau koneksi WiFi dan komunikasi ke server

---

### 6. Setup Database dan Website

**Import Database:**

- Buka http://localhost/phpmyadmin
- Buat database baru: `iot`
- Klik tab **Import** → pilih file `iot.sql` → klik **Go**

**Copy Project ke XAMPP:**

Salin seluruh folder project ke `D:\xampp\htdocs\iot\`, pastikan struktur folder benar:

```
D:\xampp\htdocs\iot\
├── application\
├── system\
├── assets\
├── index.php
└── .htaccess
```

**Konfigurasi Database:**

Buka `application/config/database.php`, pastikan isinya:

```php
'hostname' => 'localhost',
'username' => 'root',
'password' => '',
'database' => 'iot',
```

Buka `application/config/config.php`, ubah:

```php
$config['base_url'] = 'http://localhost/iot/';
```

**Jalankan Website:**

- Buka XAMPP → Start **Apache** dan **MySQL**
- Akses: http://localhost/iot/
- Login dengan akun yang tersedia

---

## Cara Kerja Sistem

1. User menginput data jadwal, umur udang, dan populasi melalui dashboard web.
2. NodeMCU ESP8266 mengambil data jadwal dan fuzzy pakan dari server via HTTP GET.
3. Sensor DS18B20 membaca suhu air secara realtime.
4. Data suhu dikirim ke server dan ditampilkan di dashboard.
5. NTP Client sinkronisasi waktu dari internet (UTC+7).
6. Ketika waktu sekarang = jadwal pakan, proses feeding dimulai.
7. Servo penampung membuka saluran pakan secara bertahap.
8. Load Cell HX711 memantau berat pakan secara realtime.
9. Ketika berat mencapai 95% dari target, servo penampung menutup.
10. Servo penimbang membuka untuk menjatuhkan pakan ke kolam.
11. Data berat akhir dikirim ke server dan disimpan ke database.
12. LCD menampilkan informasi waktu, suhu, dan berat secara realtime.

---

## Metode Fuzzy Sugeno

### Input
- Suhu Air (°C)
- Umur Udang (DOC)

### Output
- Jumlah Pakan (Gram)

### Kondisi Suhu

| Suhu | Kondisi |
|---|---|
| < 27°C | Dingin |
| 27°C – 32°C | Normal |
| > 32°C | Panas |

### Keputusan Output

- Suhu dingin → Pakan Dikurangi
- Suhu normal → Pakan Normal
- Suhu panas → Pakan Ditambah

---

## Struktur Folder

```
pemberi-pakan-udang/
│
├── kodefinalmaret/
│   └── kodefinalmaret.ino
│
├── database/
│   └── iot.sql
│
├── website/
│   ├── application/
│   ├── system/
│   ├── assets/
│   └── index.php
│
└── README.md
```

---

## Hasil Pengujian

- Sensor DS18B20 mampu membaca suhu air secara realtime dengan akurasi tinggi.
- Sensor Load Cell HX711 memiliki tingkat error rata-rata rendah dengan calibration factor 240.
- Sistem mampu memberikan pakan sesuai jadwal yang diinput melalui dashboard.
- Dashboard web dapat menampilkan data monitoring suhu dan berat secara realtime.
- Komunikasi ESP8266 ke server berjalan stabil melalui jaringan WiFi lokal.

---

## Pengembang

**Nama:** Firdaus Alfarezy  
**NIM:** 200170054  
**Program Studi:** Teknik Informatika  
**Fakultas:** Teknik  
**Universitas:** Malikussaleh  

---

## Lisensi

Project ini dibuat untuk keperluan penelitian dan pengembangan sistem otomatisasi budidaya udang berbasis Internet of Things (IoT).