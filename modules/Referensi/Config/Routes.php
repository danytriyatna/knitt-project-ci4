<?php
$routes->group("master-data/warna", ['namespace' => 'Modules\Referensi\Controllers'], static function ($routes) {
    $routes->get('/', 'RefWarna::index');

    $routes->post('list', 'RefWarna::lists');
    $routes->post('simpan', 'RefWarna::save');
});