<?php

include_once __DIR__ . '/helper.php';

spl_autoload_register(function ($classname) {
    $pathname = __DIR__ . DIRECTORY_SEPARATOR;
    $filename = str_replace('\\', DIRECTORY_SEPARATOR, $classname) . '.php';
    if (file_exists($pathname . $filename)) {
        foreach (['AliPay', 'WeChat', 'WeMini', 'WePay', 'We', 'WePay3', 'WePayPartner'] as $prefix) {
            if (stripos($classname, $prefix) === 0) {
                include $pathname . $filename;
                return true;
            }
        }
    }
    return false;
});