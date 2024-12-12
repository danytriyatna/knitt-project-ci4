<?php

$routes->group('sdm/absensi', ['namespace' => 'Modules\SDM\Controllers'], static function ($routes) {
	$routes->get('/', 'Absensi::index');
});

$routes->group('sdm/penggajian', ['namespace' => 'Modules\SDM\Controllers'], static function ($routes) {
	$routes->get('/', 'Penggajian::index');
});
