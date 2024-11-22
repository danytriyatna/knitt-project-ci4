<?php

$routes->group('purchasing/purchase-order', ['namespace' => 'Modules\Purchasing\Controllers'], static function ($routes) {
  $routes->get('/', 'PurchaseOrder::index');
  $routes->get('form', 'PurchaseOrder::form');
});

$routes->group('purchasing/receive-item', ['namespace' => 'Modules\Purchasing\Controllers'], static function ($routes) {
  $routes->get('/', 'ReceiveItem::index');
  $routes->get('form', 'ReceiveItem::form');
});

$routes->group('purchasing/purchase-payment', ['namespace' => 'Modules\Purchasing\Controllers'], static function ($routes) {
  $routes->get('/', 'PurchasePayment::index');
  $routes->get('form', 'PurchasePayment::form');
});
