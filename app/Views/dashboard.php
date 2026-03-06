<?= $this->extend('layout') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('header') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <!-- Stat Cards -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body">
                <h6 class="text-uppercase fw-bold text-muted small">Stok Rendah (ROP Hit)</h6>
                <div class="d-flex align-items-center mt-2">
                    <h2 class="fw-800 mb-0 me-3"><?= $countStokRendah ?></h2>
                    <?php if ($countStokRendah > 0): ?>
                        <span class="badge bg-danger rounded-pill fw-bold" style="font-size: 0.6rem;">PERLU PESAN</span>
                    <?php else: ?>
                        <span class="badge bg-success rounded-pill fw-bold" style="font-size: 0.6rem;">AMAN</span>
                    <?php endif; ?>
                </div>
                <p class="mt-3 mb-0 small text-muted fw-bold">Barang di bawah titik pemesanan kembali.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body">
                <h6 class="text-uppercase fw-bold text-muted small">Transaksi Hari Ini</h6>
                <div class="d-flex align-items-center mt-2">
                    <h2 class="fw-800 mb-0 me-3"><?= $countTransaksi ?></h2>
                    <span class="badge bg-dark rounded-pill fw-bold" style="font-size: 0.6rem;">AKTIVITAS</span>
                </div>
                <p class="mt-3 mb-0 small text-muted fw-bold">Total barang masuk dan keluar hari ini.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body">
                <h6 class="text-uppercase fw-bold text-muted small">Total Jenis Barang</h6>
                <div class="d-flex align-items-center mt-2">
                    <h2 class="fw-800 mb-0 me-3"><?= $countTotalBarang ?></h2>
                    <span class="badge bg-dark rounded-pill fw-bold" style="font-size: 0.6rem;">ITEM</span>
                </div>
                <p class="mt-3 mb-0 small text-muted fw-bold">Jumlah SKU yang terdaftar di sistem.</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-2">
    <!-- Chart -->
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 fw-800 text-uppercase">Grafik Penggunaan Barang (6 Bulan Terakhir)</h6>
            </div>
            <div class="card-body">
                <div id="chart-penggunaan"></div>
            </div>
        </div>
    </div>
    
    <!-- Notifications/Alerts -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 fw-800 text-uppercase">Notifikasi Stok Kritis</h6>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <?php if (empty($notifikasi)): ?>
                        <li class="list-group-item text-center py-5 text-muted small fw-bold border-0">
                            Tidak ada stok kritis saat ini. Semua dalam batas aman.
                        </li>
                    <?php else: ?>
                        <?php foreach ($notifikasi as $notif): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3 border-0 border-bottom">
                                <div>
                                    <div class="fw-800 text-uppercase small"><?= $notif['nama_barang'] ?></div>
                                    <div class="small text-danger fw-bold">Sisa: <?= $notif['stok'] ?> (ROP: <?= round($notif['rop']) ?>)</div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="card-footer bg-white border-0 text-center pb-3">
                <a href="/analisis" class="small fw-bold text-muted text-decoration-none text-uppercase">Lihat Detail Analisis</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    var options = {
        series: [{
            name: 'Barang Keluar',
            data: <?= $chartData ?>
        }],
        chart: {
            type: 'bar',
            height: 300,
            toolbar: { show: false },
            fontFamily: 'Inter, sans-serif'
        },
        plotOptions: {
            bar: { borderRadius: 4, columnWidth: '40%' }
        },
        dataLabels: { enabled: false },
        colors: ['#000000'],
        xaxis: {
            categories: <?= $chartLabels ?>,
            axisBorder: { show: false },
            axisTicks: { show: false }
        },
        yaxis: { labels: { show: false } },
        grid: {
            borderColor: '#f8f9fa',
            padding: { top: 0, right: 0, bottom: 0, left: 0 }
        },
        fill: { opacity: 1 },
        tooltip: {
            y: {
                formatter: function (val) { return val + " unit" }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart-penggunaan"), options);
    chart.render();
</script>
<?= $this->endSection() ?>
