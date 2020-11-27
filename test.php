<?php
require "vendor/autoload.php";
$client = new \GuzzleHttp\Client(['base_uri' => 'xxx']);
$request1 = new \GuzzleHttp\Psr7\Request('GET', 'http://www.sopans.com/2.php');

$start = microtime(true);

$promise1 = $client->sendAsync($request1)->then(function ($response) use ($start) {
    echo '1: ' . ceil(microtime(true) - $start) . PHP_EOL;
});
$promise2 = $client->sendAsync($request1)->then(function ($response) use ($start) {
    echo '2: ' . ceil(microtime(true) - $start) . PHP_EOL;
});
$promise3 = $client->sendAsync($request1)->then(function ($response) use ($start) {
    echo '3: ' . ceil(microtime(true) - $start) . PHP_EOL;
});
$promise4 = $client->sendAsync($request1)->then(function ($response) use ($start) {
    echo '4: ' . ceil(microtime(true) - $start) . PHP_EOL;
});
$promise5 = $client->sendAsync($request1)->then(function ($response) use ($start) {
    echo '5: ' . ceil(microtime(true) - $start) . PHP_EOL;
});
$promise1->wait();
$promise2->wait();
$promise3->wait();
$promise4->wait();
$promise5->wait();
