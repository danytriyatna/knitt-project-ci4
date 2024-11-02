<?php

$routes->group('trans/sample', ['namespace' => 'Modules\Transaction\Controllers'], static function ($routes) {
  $routes->get('/', 'Sample::index');
  $routes->get('detail/(:any)', 'Sample::detail/$1');
  $routes->get('detail-qty/(:any)', 'Sample::detailQtyUkuran/$1/$1');
  $routes->post('list', 'Sample::lists');
  $routes->post('save', 'Sample::save');
  $routes->post('save-detail', 'Sample::saveDetail');
  $routes->get('delete/list(:any)', 'Sample::deleteList/$1');
  $routes->post('generate', 'Sample::generateQRCode');
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
  $routes->post('generate', 'SalesOrder::generateQRCode');
  $routes->post('getSample', 'SalesOrder::getSampleBuyer');
});

$routes->group('trans/delivery-order', ['namespace' => 'Modules\Transaction\Controllers'], static function ($routes) {
  $routes->get('/', 'DeliveryOrder::index');
  $routes->get('form', 'DeliveryOrder::form');
});

$routes->group('trans/work-order', ['namespace' => 'Modules\Transaction\Controllers'], static function ($routes) {
  $routes->get('/', 'WorkOrder::index');
  $routes->post('list', 'WorkOrder::lists');
  $routes->post('list_warna', 'WorkOrder::lists_detail');
  $routes->get('form/(:any)', 'WorkOrder::form/$1');
  $routes->post('save-warna', 'WorkOrder::saveWarna');
  $routes->post('save-data', 'WorkOrder::save');
});

$routes->group('trans/production', ['namespace' => 'Modules\Transaction\Controllers'], static function ($routes) {
  $routes->get('/', 'Production::index');
  $routes->get('form', 'Production::form');
  $routes->get('form/(:any)', 'Production::form/$1');
  $routes->post('save', 'Production::save');
  $routes->post('list', 'Production::lists');
  $routes->post('list_ukuran', 'Production::lists_ukuran');
  $routes->post('list_detail', 'Production::getDataListProd');
});

$routes->group('trans/sales-invoice', ['namespace' => 'Modules\Transaction\Controllers'], static function ($routes) {
  $routes->get('/', 'SalesInvoice::index');
  $routes->get('form', 'SalesInvoice::form');
});

$routes->group('trans/customer-receipt', ['namespace' => 'Modules\Transaction\Controllers'], static function ($routes) {
  $routes->get('/', 'CustomerReceipt::index');
  $routes->get('form', 'CustomerReceipt::form');
});
