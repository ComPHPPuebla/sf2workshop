<?php
use Symfony\Component\HttpFoundation\Request;

chdir(__DIR__ . '/../');

require 'vendor/autoload.php';

$request = Request::createFromGlobals();

$container = require 'app/config/container.php';
$container->set('request', $request);

/** @var Symfony\Component\HttpKernel\HttpKernel $kernel */
$kernel = $container->get('kernel');

$response = $kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);
