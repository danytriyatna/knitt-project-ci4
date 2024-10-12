<?php

$routes->group('trans', ['namespace' => 'Modules\Transaction\Controllers'], static function ($routes) {
  $routes->get('sample', 'Sample::index');
  $routes->get('sample/detail/(:any)', 'Sample::detail/$1');
  $routes->get('sample/detail-qty/(:any)', 'Sample::detailQtyUkuran/$1/$1');
  $routes->post('sample/list', 'Sample::lists');
  $routes->post('sample/save', 'Sample::save');
  $routes->post('sample/save-detail', 'Sample::saveDetail');
  $routes->get('sample/delete/list(:any)', 'Sample::deleteList/$1');
  $routes->post('sample/delete/detail', 'Sample::deleteDetailList');
  $routes->get('sales-order', 'SalesOrder::index');
});
