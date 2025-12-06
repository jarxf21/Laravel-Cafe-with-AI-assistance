# ☕ Cafe Order System: AI-Integrated (Laravel, Filament, Livewire, Reverb, Gemini AI)

Sistem pemesanan kafe online yang modern dan responsif, dibangun di atas ekosistem Laravel terbarukan. Proyek ini menonjolkan penggunaan **Filament** untuk dasbor admin yang efisien, integrasi **Google Gemini API** sebagai asisten cerdas, serta fitur **Real-time** untuk pengalaman pengguna yang mulus tanpa refresh halaman.

---

## 📸 Galeri Tampilan

| Halaman Pemesanan (Mobile) | Kitchen Display System (KDS) |
| :---: | :---: |
| ![Mobile Order](https://placehold.co/300x600?text=Mobile+Order+UI) | ![KDS View](https://placehold.co/600x400?text=Kitchen+Display+System) |

> *Dashboard Admin (Filament) untuk manajemen menu dan laporan penjualan.*
> ![Admin Dashboard](https://placehold.co/800x400?text=Filament+Admin+Dashboard)
> *(Silakan ganti link gambar di atas dengan screenshot aplikasi Anda)*

---

## 📋 Prasyarat Sistem

Sebelum memulai instalasi, pastikan lingkungan pengembangan Anda memiliki:

*   **PHP**: Versi 8.2 atau lebih baru.
*   **Composer**: Untuk manajemen dependensi PHP.
*   **Node.js & NPM**: Versi 18+ (untuk compile aset Tailwind/Vite).
*   **Database**: MySQL atau MariaDB.

---

## 🚀 Tumpukan Teknologi (Tech Stack)

| Kategori | Teknologi | Peran |
| :--- | :--- | :--- |
| **Backend Framework** | **Laravel (PHP)** | Logika inti aplikasi, API handling, Job Queues, dan integrasi database. |
| **Admin Dashboard** | **Filament** | Panel admin CRUD untuk manajemen Menu, Pesanan, Kasir, dan KDS (Kitchen Display System). |
| **Frontend UI** | **Tailwind CSS** | Kerangka kerja CSS untuk desain yang responsif, modern, dan cepat. |
| **Interaktivitas** | **Livewire** | Interaksi real-time di frontend (Keranjang & Chatbot) tanpa full page refresh. |
| **Real-time** | **Laravel Reverb** | WebSocket server untuk notifikasi instan (Pesanan Masuk, Status Berubah) tanpa polling. |
| **Database** | **MySQL** | Penyimpanan data utama (Produk, Pesanan, Pengguna). |
| **AI Assistant** | **Google Gemini API** | Model AI sebagai asisten pelanggan/kasir virtual (diproses via Job Queue). |

---

## 🌟 Fitur Utama

### 1. Sistem Pemesanan Frontend (Tailwind + Livewire)
*   **Menu Interaktif**: Tampilan menu yang clean dengan filter kategori dan pencarian real-time.
*   **Keranjang Real-time**: Pengelolaan item keranjang belanja yang instan.
*   **Checkout Sederhana**: Pelanggan memesan via HP, mendapatkan "Nomor Antrian/Meja", dan status awal "Pending Payment".

### 2. Sistem Pembayaran & Kasir (Tradisional)
*   **Bayar di Kasir**: Alur pembayaran tetap dilakukan secara fisik di kasir.
*   **Cashier Approval**: Pesanan dari HP pelanggan **TIDAK** langsung muncul di dapur. Kasir harus memverifikasi pembayaran -> "Terima Pesanan".
*   **Keamanan Anti-Spam**:
    *   **Blokir Meja**: Admin dapat memblokir input dari QR Code meja tertentu.
    *   **Fingerprinting**: Pembatasan pesanan berdasarkan device.

### 3. Kitchen Display System (KDS) & Bar Display
*   **Tampilan Khusus Dapur**: Layar real-time menampilkan tiket pesanan yang *sudah dibayar*.
*   **Pemisahan Stasiun**: Otomatis pisah: "Minuman" -> Layar Bar, "Makanan" -> Layar Dapur.
*   **Manajemen Status**: Koki/Barista tekan "Selesai" -> Status "Ready to Serve" -> Notifikasi ke Pelayan.

### 4. AI Assistant (Integrasi Gemini API + Job Queues)
*   **Virtual Waiter**: Menjawab pertanyaan seputar menu & rekomendasi.
*   **Smart Ordering**: Memproses pesanan dari bahasa natural.
*   **Non-Blocking**: Menggunakan **Laravel Queues** agar UI tidak lemot saat menunggu respons AI.

---

## ⚙️ Panduan Instalasi & Persiapan Lokal

Ikuti langkah-langkah berikut untuk menjalankan proyek di komputer lokal Anda:

### 1. Clone Repository
```bash
git clone [repository-url]
cd cafe-order-system
```

### 2. Instalasi Dependensi
```bash
composer install
npm install && npm run build
```

### 3. Konfigurasi Environment (.env)
Salin file contoh konfigurasi dan generate key aplikasi:
```bash
cp .env.example .env
php artisan key:generate
```

Kemudian, buka file `.env` dan sesuaikan konfigurasi berikut:

**A. Database**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=root
DB_PASSWORD=
```

**B. Queue & Reverb (PENTING untuk AI & Real-time)**
```env
# Gunakan database untuk queue di lokal
QUEUE_CONNECTION=database

# Konfigurasi Reverb (WebSocket)
REVERB_APP_ID=my-app-id
REVERB_APP_KEY=my-app-key
REVERB_APP_SECRET=my-app-secret
REVERB_HOST="localhost"
REVERB_PORT=8080
REVERB_SCHEME="http"

# Vite harus tahu koneksi Reverb
VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
VITE_REVERB_HOST="${REVERB_HOST}"
VITE_REVERB_PORT="${REVERB_PORT}"
VITE_REVERB_SCHEME="${REVERB_SCHEME}"
```

**C. Google Gemini AI**
```env
GEMINI_API_KEY="isi_api_key_dari_google_aistudio_disini"
```

### 4. Setup Database & Reverb
Jalankan migrasi, seeder, dan mulai layanan yang dibutuhkan:

```bash
# Migrasi & Seed data awal
php artisan migrate --seed

# (Terminal Baru 1) Jalankan WebSocket Server
php artisan reverb:start

# (Terminal Baru 2) Jalankan Queue Worker untuk AI
php artisan queue:work
```

### 5. Jalankan Server
```bash
php artisan serve
```

Akses aplikasi di browser:
*   **Frontend Pelanggan**: `http://127.0.0.1:8000`
*   **Panel Admin**: `http://127.0.0.1:8000/admin`

---

## 🛠️ Troubleshooting

Jika Anda mengalami kendala saat menjalankan aplikasi:

*   **AI Chat tidak membalas?**
    *   Pastikan `QUEUE_CONNECTION=database` di `.env`.
    *   Pastikan perintah `php artisan queue:work` sedang berjalan di terminal terpisah.
*   **Pesanan tidak muncul otomatis di dapur?**
    *   Pastikan `php artisan reverb:start` sedang berjalan.
    *   Cek console browser (F12) apakah ada error WebSocket connection.
*   **Tampilan berantakan / CSS hilang?**
    *   Jalankan `npm run build` sekali lagi untuk compile asset.

---

## 📄 Lisensi

[MIT License](https://opensource.org/licenses/MIT). Silakan gunakan dan modifikasi proyek ini untuk keperluan belajar atau komersial.