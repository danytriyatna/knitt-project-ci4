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
  $routes->post('get-style-konsumen', 'Sample::getDataStyleKonsumen');
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
  $routes->post('list', 'DeliveryOrder::lists');
  $routes->post('list_produksi', 'DeliveryOrder::lists_produksi');
  $routes->get('add', 'DeliveryOrder::form');
  $routes->post('add', 'DeliveryOrder::form');
  $routes->get('form/(:any)', 'DeliveryOrder::form/$1');
  $routes->post('form/(:any)', 'DeliveryOrder::form/$1');
  $routes->post('det_produksi', 'DeliveryOrder::getDataProduksi');
  $routes->post('cari_produk', 'DeliveryOrder::getDataProduksiItem');
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
  $routes->post('list_ukuran_prod', 'Production::getDataProduksiUkuran');
  $routes->post('list_detail', 'Production::getDataListProd');
});

$routes->group('trans/sales-invoice', ['namespace' => 'Modules\Transaction\Controllers'], static function ($routes) {
  $routes->get('/', 'SalesInvoice::index');
  $routes->post('list', 'SalesInvoice::lists');
  $routes->post('list_produksi', 'SalesInvoice::lists_produksi');
  $routes->get('add', 'SalesInvoice::form');
  $routes->post('add', 'SalesInvoice::form');
  $routes->get('form/(:any)', 'SalesInvoice::form/$1');
  $routes->post('form/(:any)', 'SalesInvoice::form/$1');
  $routes->post('get_order', 'SalesInvoice::walkorder_user');
  $routes->post('cari_produk', 'SalesInvoice::getDataProduksiItem');
});

$routes->group('trans/customer-receipt', ['namespace' => 'Modules\Transaction\Controllers'], static function ($routes) {
  $routes->get('/', 'CustomerReceipt::index');
  $routes->get('form', 'CustomerReceipt::form');
});

$routes->group('trans/item-transfer', ['namespace' => 'Modules\Transaction\Controllers'], static function ($routes) {
  $routes->get('/', 'ItemTransfer::index');
  $routes->get('form', 'ItemTransfer::form');
});

$routes->group('trans/receive-item', ['namespace' => 'Modules\Transaction\Controllers'], static function ($routes) {
  $routes->get('/', 'ReceiveItem::index');
  $routes->get('form', 'ReceiveItem::form');
});

$routes->group('trans/issue-item', ['namespace' => 'Modules\Transaction\Controllers'], static function ($routes) {
  $routes->get('/', 'IssueItem::index');
  $routes->get('form', 'IssueItem::form');
});
$routes->group('trans/incoming-goods', ['namespace' => 'Modules\Transaction\Controllers'], static function ($routes) {
  $routes->get('/', 'IncomingGoods::index');
  $routes->post('list', 'IncomingGoods::lists');
  $routes->get('form', 'IncomingGoods::form');
  $routes->post('last-stock', 'IncomingGoods::getLastStock');
  $routes->post('simpan', 'IncomingGoods::save');
});
$routes->group('trans/outgoing-goods', ['namespace' => 'Modules\Transaction\Controllers'], static function ($routes) {
  $routes->get('/', 'OutgoingGoods::index');
  $routes->post('list', 'OutgoingGoods::lists');
  $routes->get('form', 'OutgoingGoods::form');
  $routes->post('last-stock', 'OutgoingGoods::getLastStock');
  $routes->post('simpan', 'OutgoingGoods::save');
});
