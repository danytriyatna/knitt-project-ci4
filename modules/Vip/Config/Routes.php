<?php

$routes->group('go-to', ['namespace' => 'Modules\Vip\Controllers'], static function ($routes) {
    $routes->get('admin', 'Vip::backToAdmin');
    
    $routes->get('login-sebagai', 'Vip::loginAs', ['filter' => 'otorisasi:MOD_LOGINAS']);
    $routes->post('login-sebagai', 'Vip::setLoginAs');
});