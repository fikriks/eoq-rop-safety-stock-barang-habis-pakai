# Progress Report - Inventory Management System

## Terbaru (Redesign & Advanced Analytics)
*   **Auth Redesign:** Merancang ulang halaman login dengan gaya **Simple Minimalism Flat (Neobrutalist)**. Menggunakan bayangan solid, sudut tajam, dan kontras tinggi untuk kesan modern.
*   **Advanced Safety Stock:** Memperbarui metodologi perhitungan dari rumus linear sederhana ke **Standard Deviation Demand**. Ini jauh lebih akurat untuk Barang Habis Pakai (BHP) yang pengambilannya tidak rutin/sporadis.
*   **Monthly Historical Analysis:**
    *   Sistem kini menyimpan riwayat analisis per bulan dan tahun.
    *   Menambahkan filter periode (Bulan/Tahun) pada halaman Analisis.
    *   Prediksi didasarkan pada *Moving Average* 12 bulan ke belakang dari periode yang dipilih.
*   **Detail Calculation Modal:** Menambahkan fitur transparansi perhitungan. Pengguna bisa melihat rincian data input (Dm, S, Hm, lt) dan bagaimana rumus EOQ/ROP diterapkan pada setiap barang.
*   **Sidebar Branding:** Mengganti teks brand dengan logo `public/logo.png` berukuran 70px dengan penyesuaian tinggi navbar (85px) agar proporsional.
*   **Bug Fixes:** 
    *   Memperbaiki error `Unknown column created_at` menjadi `dibuat_pada`.
    *   Memperbaiki kesalahan penulisan variabel `$S` pada rumus EOQ.
    *   Memperbaiki logika array standar deviasi agar menghitung varians 365 hari secara tepat.

## Fitur Utama yang Sudah Berjalan
*   **Dashboard:** Ringkasan stok dan analisis barang.
*   **Master Data:** Pengelolaan Barang, Kodering (Rekening), Harga, dan Supplier.
*   **Transaksi:** Pencatatan Barang Masuk/Keluar dengan penyesuaian stok otomatis.
*   **Analisis Stok:** Perhitungan otomatis EOQ, ROP, dan Safety Stock berbasis periode.
*   **Laporan:** Cetak laporan stok dan riwayat transaksi.

## Rencana Selanjutnya
*   Optimalisasi performa query pada data transaksi besar.
*   Fitur notifikasi stok kritis (di bawah *Safety Stock*) via dashboard.
*   Fitur ekspor hasil analisis ke PDF/Excel.
