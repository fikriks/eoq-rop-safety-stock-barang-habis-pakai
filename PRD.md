# Product Requirements Document (PRD) - Sistem Inventaris EOQ, ROP, & Safety Stock

## 1. Pendahuluan
... (tetap sama)

---

## 3. Fitur Utama (Functional Requirements)

### 3.1 Manajemen Data Master
- **Data Barang:** Nama barang, Kodering, satuan, dan stok.
- **Import Barang (Excel):** Unggah data barang secara massal.
  - *Validasi:* Cek duplikasi nama, validasi keberadaan ID Kodering.
- **Kodering (Kode Rekening):** Data diimpor secara otomatis dari file `public/kodering.xlsx`.
- **Data Harga Barang:** Manajemen riwayat harga beli per item.
- **Data Supplier:** Manajemen nama vendor/pemasok.

### 3.2 Manajemen Transaksi
- **Barang Masuk:** Pencatatan stok baru dengan referensi harga dan Supplier.
- **Import Barang Masuk (Excel):** Unggah riwayat pengadaan massal.
  - *Validasi:* Cek ID Barang, ID Harga/Harga Baru, ID Supplier.
- **Barang Keluar:** Pencatatan penggunaan barang.
- **Import Barang Keluar (Excel):** Unggah riwayat penggunaan massal.
  - *Validasi:* Cek kecukupan stok sebelum memproses import.

### 3.3 Analisis Inventory (Core Engine)
- **Modul EOQ, ROP, & Safety Stock:** Perhitungan otomatis yang dipicu setiap kali ada perubahan data (termasuk hasil import).

---

## 6. Kebutuhan Non-Fungsional
- **Teknologi:** PHP 8.2 (CodeIgniter 4), MySQL, Bootstrap 5.
- **Library Tambahan:** `phpoffice/phpspreadsheet`.
... (sisanya tetap sama)
