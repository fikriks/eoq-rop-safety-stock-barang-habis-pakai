<?= $this->extend('layout') ?>

<?= $this->section('title') ?>Analisis Stok<?= $this->endSection() ?>

<?= $this->section('header') ?>Analisis EOQ & ROP (Prediksi Bulanan)<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php 
$bulan_indo = [1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus', 9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'];
$targetDateStr = "$tahun-" . str_pad($bulan, 2, '0', STR_PAD_LEFT) . "-01";
$endDate = date('Y-m-t', strtotime("$targetDateStr -1 month"));
$startDate = date('Y-m-d', strtotime("$endDate -1 year +1 day"));

$start_m = (int)date('m', strtotime($startDate));
$start_y = date('Y', strtotime($startDate));
$end_m = (int)date('m', strtotime($endDate));
$end_y = date('Y', strtotime($endDate));

$rentang_data_historis = $bulan_indo[$start_m] . " " . $start_y . " s/d " . $bulan_indo[$end_m] . " " . $end_y;
?>
<div class="row">
    <!-- Filter Periode -->
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-4">
                <form action="/analisis" method="get" class="row align-items-end g-3">
                    <div class="col-md-4">
                        <label class="form-label small fw-800 text-muted uppercase">Pilih Bulan Prediksi</label>
                        <select name="bulan" class="form-select font-mono fw-bold">
                            <?php 
                            $bulan_indo = [1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus', 9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'];
                            foreach($bulan_indo as $num => $nama): ?>
                                <option value="<?= $num ?>" <?= ($bulan == $num) ? 'selected' : '' ?>><?= strtoupper($nama) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-800 text-muted uppercase">Tahun</label>
                        <select name="tahun" class="form-select font-mono fw-bold">
                            <?php for($i=date('Y')-1; $i<=date('Y')+1; $i++): ?>
                                <option value="<?= $i ?>" <?= ($tahun == $i) ? 'selected' : '' ?>><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-5 d-flex gap-2">
                        <button type="submit" class="btn btn-dark px-4 flex-grow-1" style="height: 42px;">
                            <i class="bi bi-filter me-2"></i>Tampilkan Analisis
                        </button>
                        <a href="/analisis" class="btn btn-light border px-4" style="height: 42px;">
                            <i class="bi bi-arrow-clockwise me-2"></i>Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Metodologi & Sumber Data -->
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; background-color: #ffffff;">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                <h6 class="m-0 fw-800 text-dark" style="letter-spacing: 0.5px;">METODOLOGI PERHITUNGAN</h6>
                <p class="small text-muted mb-0">Klik tombol <strong>Detail</strong> pada tabel untuk melihat rincian angka setiap barang.</p>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <!-- EOQ -->
                    <div class="col-md-4">
                        <div class="p-3 border rounded bg-light h-100">
                            <div class="text-center mb-3">
                                <span class="badge bg-primary text-white fw-bold mb-2">METODE 1</span>
                                <h6 class="fw-800 text-dark mb-2">EOQ (Economic Order Quantity)</h6>
                                <div class="p-2 border rounded bg-white my-2">
                                    <code class="text-dark fw-800" style="font-size: 0.9rem;">EOQ = &radic;((2 * Dm * S) / Hm)</code>
                                </div>
                                <p class="small text-muted fw-bold mb-0">Jumlah pesanan paling ekonomis</p>
                            </div>
                            <hr class="my-2">
                            <p class="small text-muted mb-2" style="font-size: 0.75rem; text-align: justify; line-height: 1.4;">
                                Berfungsi untuk menentukan jumlah kuantiti pesanan optimal yang meminimalkan total biaya persediaan (biaya pemesanan + biaya penyimpanan).
                            </p>
                            <div class="small fw-600 text-muted" style="font-size: 0.72rem;">
                                <strong class="text-dark">Keterangan Variabel:</strong>
                                <ul class="ps-3 mt-1 mb-0" style="line-height: 1.4;">
                                    <li><strong class="text-dark">Dm (Demand Month):</strong> Rata-rata permintaan bulanan (dari riwayat transaksi keluar).</li>
                                    <li><strong class="text-dark">S (Setup/Order Cost):</strong> Biaya pemesanan setiap kali transaksi dilakukan (default: Rp 50.000).</li>
                                    <li><strong class="text-dark">Hm (Holding Cost Month):</strong> Biaya penyimpanan per unit per bulan (10% harga beli barang per tahun / 12).</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Safety Stock -->
                    <div class="col-md-4">
                        <div class="p-3 border rounded bg-light h-100">
                            <div class="text-center mb-3">
                                <span class="badge bg-secondary text-white fw-bold mb-2">METODE 2</span>
                                <h6 class="fw-800 text-dark mb-2">Safety Stock (SS)</h6>
                                <div class="p-2 border rounded bg-white my-2">
                                    <code class="text-dark fw-800" style="font-size: 0.9rem;">SS = Z * std_dev * &radic;(lt)</code>
                                </div>
                                <p class="small text-muted fw-bold mb-0">Stok cadangan pengaman</p>
                            </div>
                            <hr class="my-2">
                            <p class="small text-muted mb-2" style="font-size: 0.75rem; text-align: justify; line-height: 1.4;">
                                Persediaan minimum tambahan yang dipelihara untuk mencegah terjadinya kehabisan persediaan (stockout) akibat fluktuasi permintaan harian.
                            </p>
                            <div class="small fw-600 text-muted" style="font-size: 0.72rem;">
                                <strong class="text-dark">Keterangan Variabel:</strong>
                                <ul class="ps-3 mt-1 mb-0" style="line-height: 1.4;">
                                    <li><strong class="text-dark">Z:</strong> Faktor tingkat pelayanan (konstanta 1.65 mewakili tingkat pelayanan 95%).</li>
                                    <li><strong class="text-dark">std_dev:</strong> Standar deviasi dari penggunaan harian riil (mengukur variabilitas pemakaian).</li>
                                    <li><strong class="text-dark">lt (Lead Time):</strong> Waktu tunggu kiriman dari supplier (default: 3 hari).</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- ROP -->
                    <div class="col-md-4">
                        <div class="p-3 border rounded bg-light h-100">
                            <div class="text-center mb-3">
                                <span class="badge bg-dark text-white fw-bold mb-2">METODE 3</span>
                                <h6 class="fw-800 text-dark mb-2">Reorder Point (ROP)</h6>
                                <div class="p-2 border rounded bg-white my-2">
                                    <code class="text-dark fw-800" style="font-size: 0.9rem;">ROP = (lt * d_avg) + SS</code>
                                </div>
                                <p class="small text-muted fw-bold mb-0">Titik pemesanan kembali</p>
                            </div>
                            <hr class="my-2">
                            <p class="small text-muted mb-2" style="font-size: 0.75rem; text-align: justify; line-height: 1.4;">
                                Level persediaan di mana tindakan pemesanan kembali harus segera dipicu untuk menghindari kehabisan stok sebelum kiriman baru tiba.
                            </p>
                            <div class="small fw-600 text-muted" style="font-size: 0.72rem;">
                                <strong class="text-dark">Keterangan Variabel:</strong>
                                <ul class="ps-3 mt-1 mb-0" style="line-height: 1.4;">
                                    <li><strong class="text-dark">lt (Lead Time):</strong> Waktu tunggu kiriman dari supplier (default: 3 hari).</li>
                                    <li><strong class="text-dark">d_avg:</strong> Rata-rata jumlah pemakaian barang per hari (total pemakaian setahun / 365).</li>
                                    <li><strong class="text-dark">SS:</strong> Nilai Safety Stock (stok pengaman) yang telah dihitung sebelumnya.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header bg-white border-bottom-0 py-4 px-4">
                <h6 class="m-0 fw-800 text-dark" style="letter-spacing: 0.5px;">REKOMENDASI PENGADAAN PERIODE: <?= strtoupper($bulan_indo[$bulan]) ?> <?= $tahun ?></h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr class="bg-light">
                                <th class="ps-4 py-3 border-0 text-muted small fw-800">NAMA BARANG</th>
                                <th class="py-3 border-0 text-muted small fw-800 text-center">STOK SAAT INI</th>
                                <th class="py-3 border-0 text-muted small fw-800 text-center">EOQ</th>
                                <th class="py-3 border-0 text-muted small fw-800 text-center">SAFETY STOCK</th>
                                <th class="py-3 border-0 text-muted small fw-800 text-center">ROP</th>
                                <th class="py-3 border-0 text-muted small fw-800">STATUS</th>
                                <th class="text-end pe-4 py-3 border-0 text-muted small fw-800" width="200">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($barang as $item): ?>
                                <tr class="border-bottom" style="border-color: #f1f1f1 !important;">
                                    <td class="ps-4 py-3">
                                        <div class="fw-800 text-dark text-uppercase small"><?= $item['nama_barang'] ?></div>
                                        <div class="small text-muted fw-600" style="font-size: 0.7rem;"><?= $item['nama_rekening'] ?></div>
                                    </td>
                                    <td class="text-center font-mono">
                                        <div class="fw-800"><?= $item['stok'] ?></div>
                                        <div class="small text-muted fw-bold" style="font-size: 0.65rem;"><?= $item['satuan'] ?></div>
                                    </td>
                                    <td class="text-center font-mono fw-800 text-primary">
                                        <?= $item['eoq'] ? number_format(ceil($item['eoq']), 0, ',', '.') : '0' ?>
                                    </td>
                                    <td class="text-center font-mono text-dark fw-bold">
                                        <?= $item['stok_pengaman'] ? number_format(ceil($item['stok_pengaman']), 0, ',', '.') : '0' ?>
                                    </td>
                                    <td class="text-center font-mono fw-800">
                                        <?= $item['rop'] ? number_format(ceil($item['rop']), 0, ',', '.') : '0' ?>
                                    </td>

                                    <td>
                                        <?php if ($item['rop'] && $item['stok'] <= $item['rop']): ?>
                                            <span class="badge bg-soft-danger text-danger fw-800" style="font-size: 0.65rem; background-color: #fbe9e7;">PERLU PESAN</span>
                                        <?php else: ?>
                                            <span class="badge bg-soft-success text-success fw-800" style="font-size: 0.65rem; background-color: #e8f5e9;">STOK AMAN</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end pe-4 py-3 text-nowrap">
                                        <button class="btn btn-light btn-sm fw-bold border me-1" onclick='showDetail(<?= json_encode($item) ?>)'>
                                            <i class="bi bi-eye-fill me-1 text-primary"></i>Detail
                                        </button>
                                        <a href="/analisis/hitung/<?= $item['id'] ?>?bulan=<?= $bulan ?>&tahun=<?= $tahun ?>" class="btn btn-light btn-sm fw-bold border">
                                            <i class="bi bi-arrow-repeat me-1 text-muted"></i>Hitung
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Analisis -->
<div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-bottom-0 pt-4 px-4">
                <h6 class="modal-title fw-800 text-uppercase"><i class="bi bi-info-circle-fill me-2 text-primary"></i>RINCIAN PERHITUNGAN: <span id="det_nama"></span></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pb-4">
                <div class="alert bg-light border-0 small mb-4" style="border-radius: 10px;">
                    <div class="row">
                        <div class="col-md-6 mb-2 mb-md-0">
                            <span class="text-muted fw-bold d-block uppercase" style="font-size: 0.65rem; letter-spacing: 0.5px;">Bulan & Tahun Prediksi:</span>
                            <strong class="text-dark fs-6"><?= strtoupper($bulan_indo[$bulan]) ?> <?= $tahun ?></strong>
                        </div>
                        <div class="col-md-6">
                            <span class="text-muted fw-bold d-block uppercase" style="font-size: 0.65rem; letter-spacing: 0.5px;">Rentang Data Historis Penggunaan:</span>
                            <strong class="text-dark fs-6"><?= strtoupper($rentang_data_historis) ?></strong>
                        </div>
                    </div>
                    <hr class="my-2" style="border-color: #ddd;">
                    <p class="m-0 text-muted" style="font-size: 0.7rem; line-height: 1.45;">
                        <i class="bi bi-info-circle-fill text-primary me-1"></i> Data historis penggunaan (<strong>Transaksi Keluar</strong>) ditarik dari rentang 12 bulan terakhir sebelum periode prediksi untuk menghasilkan perhitungan EOQ, Safety Stock, dan ROP secara presisi.
                    </p>
                </div>
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="fw-800 small text-muted uppercase mb-3">DATA INPUT (DARI SISTEM)</h6>
                        <table class="table table-sm table-bordered small">
                            <tr class="bg-light">
                                <td class="fw-bold">Rata-rata Permintaan Bulanan (Dm)</td>
                                <td class="font-mono text-end" id="det_dm">0</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Biaya Pemesanan (S)</td>
                                <td class="font-mono text-end" id="det_s">0</td>
                            </tr>
                            <tr class="bg-light">
                                <td class="fw-bold">Biaya Simpan Bulanan (Hm)</td>
                                <td class="font-mono text-end" id="det_hm">0</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Lead Time / Waktu Tunggu (lt)</td>
                                <td class="font-mono text-end" id="det_lt">0 Hari</td>
                            </tr>
                            <tr class="bg-light">
                                <td class="fw-bold">Rata-rata Penggunaan Harian (d_avg)</td>
                                <td class="font-mono text-end" id="det_davg">0</td>
                            </tr>
                        </table>
                        <p class="text-muted" style="font-size: 0.65rem;">* Data Dm & d_avg ditarik dari riwayat transaksi 12 bulan terakhir sebelum periode prediksi.</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-800 small text-muted uppercase mb-3">HASIL ANALISIS</h6>
                        
                        <div class="p-3 bg-light rounded mb-3 border">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="small fw-bold">EOQ (Pesanan Optimal)</span>
                                <span class="fw-800 text-primary fs-5" id="det_eoq_val">0</span>
                            </div>
                            <p class="m-0 text-muted" style="font-size: 0.65rem;">
                                Rumus: sqrt((2 * <span id="eq_dm">0</span> * <span id="eq_s">0</span>) / <span id="eq_hm">0</span>)
                            </p>
                        </div>

                        <div class="p-3 bg-light rounded mb-3 border">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="small fw-bold">SAFETY STOCK</span>
                                <span class="fw-800 text-dark fs-5" id="det_ss_val">0</span>
                            </div>
                            <p class="m-0 text-muted" style="font-size: 0.65rem;">
                                Rumus: Z(1.65) * std_dev * sqrt(lt)
                            </p>
                        </div>

                        <div class="p-3 bg-dark text-white rounded border">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="small fw-bold text-uppercase">REORDER POINT (ROP)</span>
                                <span class="fw-800 fs-4" id="det_rop_val">0</span>
                            </div>
                            <p class="m-0 text-white-50" style="font-size: 0.65rem;">
                                Rumus: (lt * d_avg) + Safety Stock
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light py-3 px-4" style="border-radius: 0 0 16px 16px;">
                <p class="m-0 small text-muted flex-grow-1">Terakhir dihitung: <span id="det_tgl" class="fw-bold"></span></p>
                <button type="button" class="btn btn-dark px-4 fw-bold" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function showDetail(item) {
    if (!item.terakhir_dihitung_pada) {
        alert('Data analisis belum dihitung untuk periode ini.');
        return;
    }

    document.getElementById('det_nama').textContent = item.nama_barang;
    
    // Data Input
    document.getElementById('det_dm').textContent = parseFloat(item.permintaan_tahunan || 0).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 10 });
    document.getElementById('det_s').textContent = 'Rp ' + parseInt(item.biaya_pemesanan || 0).toLocaleString('id-ID');
    document.getElementById('det_hm').textContent = 'Rp ' + parseFloat(item.biaya_penyimpanan || 0).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 10 });
    document.getElementById('det_lt').textContent = (item.waktu_tunggu || 0) + ' Hari';
    document.getElementById('det_davg').textContent = parseFloat(item.permintaan_rata_rata || 0).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 10 });
    
    // Rumus breakdown
    document.getElementById('eq_dm').textContent = parseFloat(item.permintaan_tahunan || 0).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 10 });
    document.getElementById('eq_s').textContent = parseInt(item.biaya_pemesanan || 0);
    document.getElementById('eq_hm').textContent = parseFloat(item.biaya_penyimpanan || 0).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 10 });

    // Hasil Final
    document.getElementById('det_eoq_val').textContent = Math.ceil(parseFloat(item.eoq || 0)).toLocaleString('id-ID') + ' ' + item.satuan;
    document.getElementById('det_ss_val').textContent = Math.ceil(parseFloat(item.stok_pengaman || 0)).toLocaleString('id-ID') + ' ' + item.satuan;
    document.getElementById('det_rop_val').textContent = Math.ceil(parseFloat(item.rop || 0)).toLocaleString('id-ID') + ' ' + item.satuan;
    
    document.getElementById('det_tgl').textContent = item.terakhir_dihitung_pada;

    new bootstrap.Modal(document.getElementById('modalDetail')).show();
}
</script>
<?= $this->endSection() ?>
