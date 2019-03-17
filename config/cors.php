<?php
/**
 * Created by PhpStorm.
 * User: tobys
 * Date: 12/03/2019
 * Time: 13:52
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Laravel CORS
    |--------------------------------------------------------------------------
    |
    | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
    | to accept any value.
    |
    */

    'supportsCredentials' => false,
    'allowedOrigins' => ['*'],
    'allowedOriginsPatterns' => [],
    'allowedHeaders' => ['*'],
    'allowedMethods' =>  ['GET', 'POST', 'PUT', 'PATCH',  'DELETE'],
    'exposedHeaders' => [],
    'maxAge' => 0,
];