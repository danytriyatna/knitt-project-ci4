<?php

function assets_url($dir = null){

    if( !empty( $dir ) ){
        return base_url() . '/assets' . $dir;
    }else{
        return base_url() . '/assets';
    }
    
}