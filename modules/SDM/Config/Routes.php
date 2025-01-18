<?php

$routes->group('sdm/absensi', ['namespace' => 'Modules\SDM\Controllers'], static function ($routes) {
	$routes->get('/', 'Absensi::index');
	$routes->post('list', 'Absensi::lists');
	$routes->post('dataGenerate', 'Absensi::generate_absen_karyawan');
	$routes->post('saveData', 'Absensi::simpanData');
	$routes->post('importData', 'Absensi::import_excel');
});

$routes->group('sdm/penggajian', ['namespace' => 'Modules\SDM\Controllers'], static function ($routes) {
	$routes->get('/', 'Penggajian::index');
	$routes->post('get_laporan', 'Penggajian::getDataPenggajian');
});
