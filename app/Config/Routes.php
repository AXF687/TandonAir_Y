<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('/','Admin\DashboardController::index');
$routes->get('dashboard','Admin\DashboardController::index');
$routes->get('produk','Admin\ProdukController::index');
$routes->get('produk/kategori','Admin\ProdukController::kategori');
$routes->post('produk/kategori/tambah','Admin\ProdukController::simpan');
$routes->post('produk/kategori/edit/(:num)','Admin\ProdukController::ubah/$1');

//fungsi kendali relay
$routes->get('kendali','KendaliController::index');
$routes->get('nilai-relay/(:num)','KendaliController::ubah/$1');

//fungsi monitor suhu & kelembaban
$routes->get('sensor','SensorController::index');
$routes->get('ceksuhu','SensorController::ceksuhu');
$routes->get('cekkelembaban','SensorController::cekkelembaban');
$routes->get('sensor/grafiksuhu','SensorController::getSuhu');
$routes->get('terima-data/(:segment)/(:segment)', 'SensorController::update/$1/$2');

//fungsi kendali relay
$routes->get('kendali/(:segment)','KendaliController::update/$1');

//fungsi monitor air

$routes->get('pompa', 'PompaController::index');                   // Halaman utama monitoring
$routes->get('cekpompa', 'PompaController::cekpompa');     // API untuk mendapatkan status pompa
$routes->get('pompa/grafikpompa', 'PompaController::getPompa'); // API untuk memperbarui status pompa
$routes->get('oleh-data/(:segment)', 'PompaController::update/$1'); // Endpoint untuk menerima data eksternal

//fungsi relay pompa 
$routes->get('manual','PompaController::index');
$routes->get('value-relay/(:num)','PompaController::ganti/$1');

//fungsi mode auto atau manual
$routes->get('mode', 'ModeController::index'); // Halaman mode
$routes->post('switch-mode', 'ModeController::switchMode'); // API untuk mengubah mode

// //fungsi relay pompa 
// $routes->get('manual','ManualController::index');
// $routes->get('value-relay/(:num)','ManualController::ganti/$1');

// //fungsi mode auto atau manual
// $routes->get('mode', 'ModeController::index'); // Halaman mode
// $routes->post('switch-mode', 'ModeController::switchMode'); // API untuk mengubah mode