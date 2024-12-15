<?php

$routes->group('sdm/absensi', ['namespace' => 'Modules\SDM\Controllers'], static function ($routes) {
	$routes->get('/', 'Absensi::index');
	$routes->post('list', 'Absensi::lists');
	$routes->post('dataGenerate', 'Absensi::generate_absen_karyawan');
	$routes->post('saveData', 'Absensi::simpanData');
});

$routes->group('sdm/penggajian', ['namespace' => 'Modules\SDM\Controllers'], static function ($routes) {
	$routes->get('/', 'Penggajian::index');
});
