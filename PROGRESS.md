# Progress Report - Inventory Management System

## Terbaru (Redesign, Advanced Analytics & Documentation)
*   **Final Documentation & Cleanup:**
    *   Memperbarui `README.md` dengan informasi proyek yang relevan dan panduan instalasi.
    *   Sinkronisasi dokumentasi teknis dengan fitur terbaru yang diimplementasikan.
    *   Pengecekan akhir pada diagram UML (Activity, Sequence, Class) untuk memastikan konsistensi alur sistem.
*   **Enhanced Analysis Precision & Transparency:**
    *   Menampilkan nilai **Standar Deviasi Harian (std_dev)** secara eksplisit pada modal detail analisis.
    *   Memperbarui breakdown rumus pada modal detail (EOQ, Safety Stock, ROP) dengan angka variabel riil untuk transparansi kalkulasi.
    *   Memperbaiki bug penyimpanan `standar_deviasi` pada database melalui pembaruan `AnalisisStokModel`.
    *   Optimasi dashboard untuk memfilter notifikasi stok kritis berdasarkan periode bulan berjalan (mencegah data duplikat).
*   **Comprehensive UML Documentation:**
    *   Membuat **ER Diagram (ERD)** yang mencakup 7 tabel utama beserta relasinya.
    *   Membuat **Class Diagram** yang memetakan arsitektur MVC (Controllers & Models).
    *   Membuat **Use Case Diagram** untuk memetakan peran Admin dan Petugas.
    *   Membuat **Activity Diagram** detail untuk alur Login, Master Data, Transaksi, dan Analisis.
    *   Membuat **Sequence Diagram** standar dengan *activation bars* untuk interaksi antar objek.
    *   Semua diagram tersedia dalam format `.drawio` di folder `docs/` untuk kemudahan pengeditan.
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
