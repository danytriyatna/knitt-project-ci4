<?php

$routes->group('trans/sample', ['namespace' => 'Modules\Transaction\Controllers'], static function ($routes) {
  $routes->get('/', 'Sample::index');
  $routes->get('detail/(:any)', 'Sample::detail/$1');
  $routes->get('detail-qty/(:any)', 'Sample::detailQtyUkuran/$1/$1');
  $routes->post('list', 'Sample::lists');
  $routes->post('save', 'Sample::save');
  $routes->post('save-detail', 'Sample::saveDetail');
  $routes->get('delete/list(:any)', 'Sample::deleteList/$1');
  $routes->post('delete/detail', 'Sample::deleteDetailList');
});

$routes->group('trans/sales-order', ['namespace' => 'Modules\Transaction\Controllers'], static function ($routes) {
  $routes->get('/', 'SalesOrder::index');
  $routes->get('detail/(:any)', 'SalesOrder::detail/$1');
  $routes->get('detail-qty/(:any)', 'SalesOrder::detailQtyUkuran/$1/$1');
  $routes->post('list', 'SalesOrder::lists');
  $routes->post('save', 'SalesOrder::save');
  $routes->post('save-detail', 'SalesOrder::saveDetail');
  $routes->get('delete/list(:any)', 'SalesOrder::deleteList/$1');
  $routes->get('delete/detail(:any)', 'SalesOrder::deleteDetailList/$1');
  $routes->post('getSample', 'SalesOrder::getSampleBuyer');
});

$routes->group('trans/delivery-order', ['namespace' => 'Modules\Transaction\Controllers'], static function ($routes) {
  $routes->get('/', 'DeliveryOrder::index');
  $routes->get('form/(:any)', 'DeliveryOrder::form/$1');
});

$routes->group('trans/work-order', ['namespace' => 'Modules\Transaction\Controllers'], static function ($routes) {
  $routes->get('/', 'WorkOrder::index');
  $routes->post('list', 'WorkOrder::lists');
  $routes->get('form/(:any)', 'WorkOrder::form/$1');
});

$routes->group('trans/production', ['namespace' => 'Modules\Transaction\Controllers'], static function ($routes) {
  $routes->get('/', 'Production::index');
  $routes->get('form', 'Production::form');
});
