<?php

$routes->group('trans', ['namespace' => 'Modules\Transaction\Controllers'], static function ($routes) {
  $routes->get('sample', 'Sample::index');
  $routes->get('sales-order', 'SalesOrder::index');
});