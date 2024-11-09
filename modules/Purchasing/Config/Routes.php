<?php

$routes->group('purchasing/purchase-order', ['namespace' => 'Modules\Purchasing\Controllers'], static function ($routes) {
  $routes->get('/', 'PurchaseOrder::index');
  $routes->get('form', 'PurchaseOrder::form');
});

$routes->group('purchasing/receipt-order', ['namespace' => 'Modules\Purchasing\Controllers'], static function ($routes) {
  $routes->get('/', 'ReceiptOrder::index');
  $routes->get('form', 'ReceiptOrder::form');
});
