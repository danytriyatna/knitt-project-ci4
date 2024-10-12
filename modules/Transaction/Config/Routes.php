<?php

$routes->group('trans/sample', ['namespace' => 'Modules\Transaction\Controllers'], static function ($routes) {
  $routes->get('/', 'Sample::index');
  $routes->get('detail/(:any)', 'Sample::detail/$1');
  $routes->get('detail-qty/(:any)', 'Sample::detailQtyUkuran/$1/$1');
  $routes->post('list', 'Sample::lists');
  $routes->post('save', 'Sample::save');
  $routes->get('delete/list(:any)', 'Sample::deleteList/$1');
  $routes->get('delete/detail(:any)', 'Sample::deleteDetailList/$1');
});

$routes->group('trans/sales-order', ['namespace' => 'Modules\Transaction\Controllers'], static function ($routes) {
  $routes->get('/', 'SalesOrder::index');
  $routes->get('detail/(:any)', 'SalesOrder::detail/$1');
  $routes->post('list', 'SalesOrder::lists');
  $routes->post('save', 'SalesOrder::save');
  $routes->get('delete/list(:any)', 'SalesOrder::deleteList/$1');
  $routes->get('delete/detail(:any)', 'SalesOrder::deleteDetailList/$1');
});
