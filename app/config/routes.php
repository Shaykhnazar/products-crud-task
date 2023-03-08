<?php

return [
    '' => [
        'controller' => 'main',
        'action' => 'index',
    ],

    'account/login' => [
        'controller' => 'account',
        'action' => 'login',
    ],

    'api/account/signin' => [
        'controller' => 'account',
        'action' => 'signin',
    ],

    'products/index' => [
        'controller' => 'product',
        'action' => 'index',
    ],

    'api/products/getlist' => [
        'controller' => 'product',
        'action' => 'getlist',
    ],

    'api/products/store' => [
        'controller' => 'product',
        'action' => 'store',
    ],

    'api/products/update' => [
        'controller' => 'product',
        'action' => 'update',
    ],

    'api/products/delete' => [
        'controller' => 'product',
        'action' => 'delete',
    ],

    'api/sku/generate' => [
        'controller' => 'sku_setting',
        'action' => 'generate',
    ],

    'api/sku/update' => [
        'controller' => 'sku_setting',
        'action' => 'update',
    ],


];