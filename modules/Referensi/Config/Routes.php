<?php
$routes->group("master-data/warna", ['namespace' => 'Modules\Referensi\Controllers'], static function ($routes) {
    $routes->get('/', 'RefWarna::index');

    $routes->post('list', 'RefWarna::lists');
    $routes->post('simpan', 'RefWarna::save');
    $routes->get('delete/(:any)', 'RefWarna::deactivate/$1');
});

$routes->group("master-data/ukuran", ['namespace' => 'Modules\Referensi\Controllers'], static function ($routes) {
    $routes->get('/', 'RefUkuran::index');

    $routes->post('list', 'RefUkuran::lists');
    $routes->post('simpan', 'RefUkuran::save');
    $routes->get('delete/(:any)', 'RefUkuran::deactivate/$1');
});

$routes->group("master-data/konsumen", ['namespace' => 'Modules\Referensi\Controllers'], static function ($routes) {
    $routes->get('/', 'RefKonsumen::index');

    $routes->post('list', 'RefKonsumen::lists');
    $routes->post('simpan', 'RefKonsumen::save');
    $routes->get('delete/(:any)', 'RefKonsumen::deactivate/$1');
});