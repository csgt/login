<?php
return array( 

    /*
    |--------------------------------------------------------------------------
    | oAuth Config
    |--------------------------------------------------------------------------
    */
    'storage' => 'Session', 
    'consumers' => array(
        'Facebook' => array(
            'client_id'     => '117914121575630', //Config::get('login::facebook.clientid'),
            'client_secret' => '6f5ea1fca979271a0f13da59f8fb0bf2', //Config::get('login::facebook.clientsecret'),
            'scope'         => array('email')// Config::get('login::facebook.scope'),
        ),      
    )
);