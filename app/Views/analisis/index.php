<?= $this->extend('layout') ?>

<?= $this->section('title') ?>Analisis Stok<?= $this->endSection() ?>

<?= $this->section('header') ?>Analisis EOQ & ROP (Prediksi Bulanan)<?= $this->endSection() ?>

<?= $this->section('content') ?>
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
                <div class="row g-4 text-center">
                    <div class="col-md-4">
                        <div class="p-2 border rounded bg-light mb-2">
                            <code class="text-dark fw-800" style="font-size: 0.9rem;">EOQ = sqrt((2 * Dm * S) / Hm)</code>
                        </div>
                        <p class="small text-muted mb-0">Jumlah pesanan paling ekonomis</p>
                    </div>
                    <div class="col-md-4">
                        <div class="p-2 border rounded bg-light mb-2">
                            <code class="text-dark fw-800" style="font-size: 0.9rem;">SS = Z * std_dev * sqrt(lt)</code>
                        </div>
                        <p class="small text-muted mb-0">Stok cadangan pengaman</p>
                    </div>
                    <div class="col-md-4">
                        <div class="p-2 border rounded bg-light mb-2">
                            <code class="text-dark fw-800" style="font-size: 0.9rem;">ROP = (lt * d_avg) + SS</code>
                        </div>
                        <p class="small text-muted mb-0">Titik pemesanan kembali</p>
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
                                        <?= $item['eoq'] ? round($item['eoq']) : '0' ?>
                                    </td>
                                    <td class="text-center font-mono text-dark fw-bold">
                                        <?= $item['stok_pengaman'] ? round($item['stok_pengaman']) : '0' ?>
                                    </td>
                                    <td class="text-center font-mono fw-800">
                                        <?= $item['rop'] ? round($item['rop']) : '0' ?>
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
    document.getElementById('det_dm').textContent = parseFloat(item.permintaan_tahunan || 0).toFixed(2);
    document.getElementById('det_s').textContent = 'Rp ' + parseInt(item.biaya_pemesanan || 0).toLocaleString('id-ID');
    document.getElementById('det_hm').textContent = 'Rp ' + parseFloat(item.biaya_penyimpanan || 0).toFixed(2);
    document.getElementById('det_lt').textContent = (item.waktu_tunggu || 0) + ' Hari';
    document.getElementById('det_davg').textContent = parseFloat(item.permintaan_rata_rata || 0).toFixed(4);
    
    // Rumus breakdown
    document.getElementById('eq_dm').textContent = parseFloat(item.permintaan_tahunan || 0).toFixed(2);
    document.getElementById('eq_s').textContent = parseInt(item.biaya_pemesanan || 0);
    document.getElementById('eq_hm').textContent = parseFloat(item.biaya_penyimpanan || 0).toFixed(2);

    // Hasil Final
    document.getElementById('det_eoq_val').textContent = Math.round(item.eoq || 0) + ' ' + item.satuan;
    document.getElementById('det_ss_val').textContent = Math.round(item.stok_pengaman || 0) + ' ' + item.satuan;
    document.getElementById('det_rop_val').textContent = Math.round(item.rop || 0) + ' ' + item.satuan;
    
    document.getElementById('det_tgl').textContent = item.terakhir_dihitung_pada;

    new bootstrap.Modal(document.getElementById('modalDetail')).show();
}
</script>
<?= $this->endSection() ?>
