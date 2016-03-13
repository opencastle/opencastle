<?php

use Symfony\Component\HttpFoundation\Request;

// If you don't want to setup permissions the proper way, just uncomment the following PHP line
// read http://symfony.com/doc/current/book/installation.html#checking-symfony-application-configuration-and-setup
// for more information
//umask(0000);

// This check prevents access to debug front controllers that are deployed by accident to production servers.
// Feel free to remove this, extend it, or make something more sophisticated.


if ($_SERVER['SERVER_ADDR'] != '192.168.123.45'
    || $_SERVER['SERVER_ADDR'] != '127.0.0.1'
    || isset($_SERVER['HTTP_CLIENT_IP'])
    || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
) {
    header('HTTP/1.0 403 Forbidden');
    exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
}


$loader = require_once __DIR__.'/../app/bootstrap.php.cache';

// Enable APC for autoloading to improve performance.
// You should change the ApcClassLoader first argument to a unique prefix
// in order to prevent cache key conflicts with other applications
// also using APC.

require_once __DIR__.'/../app/AppKernel.php';

$kernel = new AppKernel('test', false);
$kernel->loadClassCache();

// When using the HttpCache, you need to call the method in your front controller instead of relying on the configuration parameter
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
