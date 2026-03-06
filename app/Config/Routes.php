<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AuthController::index');
$routes->get('/login', 'AuthController::index');
$routes->post('/auth/login', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');

$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'HomeController::index');
    
    $routes->get('kodering', 'KoderingController::index');

    $routes->get('barang', 'BarangController::index');
    $routes->post('barang/simpan', 'BarangController::simpan');
    $routes->post('barang/ubah', 'BarangController::ubah');
    $routes->post('barang/import', 'BarangController::import');
    $routes->get('barang/hapus/(:num)', 'BarangController::hapus/$1');

    $routes->get('harga', 'HargaController::index');
    $routes->get('harga/detail/(:num)', 'HargaController::detail/$1');
    $routes->post('harga/simpan', 'HargaController::simpan');
    $routes->get('harga/hapus/(:num)', 'HargaController::hapus/$1');

    $routes->get('supplier', 'SupplierController::index');
    $routes->post('supplier/simpan', 'SupplierController::simpan');
    $routes->post('supplier/ubah', 'SupplierController::ubah');
    $routes->get('supplier/hapus/(:num)', 'SupplierController::hapus/$1');

    $routes->get('transaksi/masuk', 'TransaksiController::masuk');
    $routes->get('transaksi/keluar', 'TransaksiController::keluar');
    $routes->post('transaksi/simpan', 'TransaksiController::simpan');
    $routes->post('transaksi/import-masuk', 'TransaksiController::import_masuk');
    $routes->post('transaksi/import-keluar', 'TransaksiController::import_keluar');
    $routes->get('transaksi/hapus/(:num)', 'TransaksiController::hapus/$1');

    $routes->get('analisis', 'AnalisisController::index');
    $routes->get('analisis/hitung-semua', 'AnalisisController::hitung_semua_otomatis');
    $routes->get('analisis/hitung/(:num)', 'AnalisisController::hitung/$1');
    $routes->post('analisis/simpan', 'AnalisisController::simpan');

    $routes->get('laporan/stok', 'LaporanController::stok');
    $routes->get('laporan/transaksi', 'LaporanController::transaksi');

    $routes->get('template/barang', 'TemplateController::barang');
    $routes->get('template/transaksi-masuk', 'TemplateController::transaksi_masuk');
    $routes->get('template/transaksi-keluar', 'TemplateController::transaksi_keluar');
});
