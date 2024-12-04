<?php

$routes->group('laporan/stock-card', ['namespace' => 'Modules\Laporan\Controllers'], static function ($routes) {
    $routes->get('/', 'LaporanStockCard::index');
    $routes->get('list', 'LaporanStockCard::getDataLaporanStockCard');
});
