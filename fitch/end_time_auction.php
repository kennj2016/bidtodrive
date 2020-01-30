<?php

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

$rootUrl = getenv('ROOT_URL');

$client = new GuzzleHttp\Client();
$res = $client->request('POST', $rootUrl.'/fitch/index.php?cmd=end_time_auction', [
    'auth' => ['user', 'pass']
]);

echo $res->getBody();
