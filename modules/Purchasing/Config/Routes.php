<?php

$routes->group('purchasing/purchase-order', ['namespace' => 'Modules\Purchasing\Controllers'], static function ($routes) {
  $routes->get('/', 'PurchaseOrder::index');
  $routes->post('list', 'PurchaseOrder::lists');
  $routes->post('save', 'PurchaseOrder::save');
  $routes->get('form', 'PurchaseOrder::form');
  $routes->get('form/(:any)', 'PurchaseOrder::form/$1');
});

$routes->group('purchasing/receive-item', ['namespace' => 'Modules\Purchasing\Controllers'], static function ($routes) {
  $routes->get('/', 'ReceiveItem::index');
  $routes->get('form', 'ReceiveItem::form');
  $routes->post('list', 'ReceiveItem::lists');
  $routes->post('list-barang', 'ReceiveItem::listsBarang');
  $routes->post('save', 'ReceiveItem::save');
  $routes->get('form/(:any)', 'ReceiveItem::form/$1');
  $routes->get('check-lot', 'ReceiveItem::checkLotsNo');
});

$routes->group('purchasing/purchase-payment', ['namespace' => 'Modules\Purchasing\Controllers'], static function ($routes) {
  $routes->get('/', 'PurchasePayment::index');
  $routes->get('form', 'PurchasePayment::form');
  $routes->post('list', 'PurchasePayment::lists');
  $routes->post('save', 'PurchasePayment::save');
  $routes->get('form/(:any)', 'PurchasePayment::form/$1');
  $routes->get('list-payment', 'PurchasePayment::getDataPayment');
});
