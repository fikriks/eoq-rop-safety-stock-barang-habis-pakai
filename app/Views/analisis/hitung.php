<?= $this->extend('layout') ?>

<?= $this->section('title') ?>Pengaturan Parameter<?= $this->endSection() ?>

<?= $this->section('header') ?>Atur Parameter: <?= $barang['nama_barang'] ?><?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="/analisis">Analisis</a></li>
<li class="breadcrumb-item active">Hitung</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <form action="/analisis/simpan" method="post" id="formAnalisis">
                <?= csrf_field() ?>
                <input type="hidden" name="id_barang" value="<?= $barang['id'] ?>">
                
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
                        <div>
                            <h6 class="fw-800 text-dark m-0">1. PARAMETER EOQ (Economic Order Quantity)</h6>
                            <small class="text-primary fw-bold">Harga Unit Terbaru: Rp <?= number_format($unitPrice, 0, ',', '.') ?></small>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary fw-bold" onclick="fillSuggestedEOQ()">
                            <i class="bi bi-magic me-1"></i>Gunakan Saran Riwayat
                        </button>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label small fw-800 text-muted">KEBUTUHAN TAHUNAN (D) <span class="text-danger">*</span></label>
                            <input type="number" name="permintaan_tahunan" id="D" class="form-control py-2" value="<?= $analisis['permintaan_tahunan'] ?? '' ?>" placeholder="E.g. 1200" required>
                            <div class="form-text small text-muted">Saran riwayat (1 tahun terakhir): <strong><?= $suggested['D'] ?> unit</strong></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-800 text-muted">BIAYA PEMESANAN (S) <span class="text-danger">*</span></label>
                            <input type="number" name="biaya_pemesanan" id="S" class="form-control py-2" value="<?= $analisis['biaya_pemesanan'] ?? '' ?>" placeholder="E.g. 50000" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-800 text-muted">BIAYA PENYIMPANAN (H) <span class="text-danger">*</span></label>
                            <input type="number" name="biaya_penyimpanan" id="H" class="form-control py-2" value="<?= $analisis['biaya_penyimpanan'] ?? '' ?>" placeholder="E.g. 5000" required>
                            <div class="form-text small text-muted">Saran (10% dari harga terbaru): <strong>Rp <?= number_format($suggested['H'], 0, ',', '.') ?></strong></div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4 mb-4 border-bottom pb-2">
                        <h6 class="fw-800 text-dark m-0">2. PARAMETER SAFETY STOCK & ROP</h6>
                        <button type="button" class="btn btn-sm btn-outline-primary fw-bold" onclick="fillSuggestedROP()">
                            <i class="bi bi-magic me-1"></i>Gunakan Saran Riwayat
                        </button>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-800 text-muted">LEAD TIME RATA-RATA (HARI) <span class="text-danger">*</span></label>
                            <input type="number" name="waktu_tunggu" id="lt_avg" class="form-control py-2" value="<?= $analisis['waktu_tunggu'] ?? '' ?>" placeholder="E.g. 3" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-800 text-muted">LEAD TIME MAKSIMUM (HARI) <span class="text-danger">*</span></label>
                            <input type="number" name="waktu_tunggu_maksimum" id="lt_max" class="form-control py-2" value="<?= $analisis['waktu_tunggu_maksimum'] ?? '' ?>" placeholder="E.g. 7" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-800 text-muted">PENGGUNAAN RATA-RATA / HARI <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="permintaan_rata_rata" id="d_avg" class="form-control py-2" value="<?= $analisis['permintaan_rata_rata'] ?? '' ?>" placeholder="E.g. 5" required>
                            <div class="form-text small text-muted">Saran riwayat: <strong><?= $suggested['d_avg'] ?> unit/hari</strong></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-800 text-muted">PENGGUNAAN MAKSIMUM / HARI <span class="text-danger">*</span></label>
                            <input type="number" name="permintaan_maksimum" id="d_max" class="form-control py-2" value="<?= $analisis['permintaan_maksimum'] ?? '' ?>" placeholder="E.g. 15" required>
                            <div class="form-text small text-muted">Saran riwayat: <strong><?= $suggested['d_max'] ?> unit/hari</strong></div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 p-4 pt-0 d-flex gap-2">
                    <button type="submit" class="btn btn-dark px-4 py-2 shadow-sm">
                        <i class="bi bi-calculator-fill me-2"></i>Simpan & Hitung Analisis
                    </button>
                    <a href="/analisis" class="btn btn-light px-4 border">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4 mt-4 mt-lg-0">
        <div class="card border-0 bg-dark text-white p-4 shadow-sm" style="border-radius: 12px;">
            <h6 class="fw-800 uppercase small border-bottom border-secondary pb-2 mb-3">Informasi Otomatis</h6>
            <p class="small text-muted mb-3">Sistem menghitung saran nilai berdasarkan data <strong>Transaksi Keluar</strong> dalam 1 tahun terakhir.</p>
            <div class="alert bg-secondary text-white border-0 small py-2 mb-0">
                <i class="bi bi-info-circle me-2"></i> Klik tombol <strong>"Gunakan Saran"</strong> untuk mengisi form secara instan.
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function fillSuggestedEOQ() {
        document.getElementById('D').value = "<?= $suggested['D'] ?>";
        document.getElementById('H').value = "<?= $suggested['H'] ?>";
        document.getElementById('S').value = "<?= $suggested['S'] ?>";
        notyf.success('Parameter EOQ diisi dari riwayat.');
    }

    function fillSuggestedROP() {
        document.getElementById('d_avg').value = "<?= $suggested['d_avg'] ?>";
        document.getElementById('d_max').value = "<?= $suggested['d_max'] ?>";
        document.getElementById('lt_avg').value = "<?= $suggested['lt_avg'] ?>";
        document.getElementById('lt_max').value = "<?= $suggested['lt_max'] ?>";
        notyf.success('Parameter ROP diisi dari riwayat.');
    }
</script>
<?= $this->endSection() ?>
