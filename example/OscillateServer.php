<?php
include(dirname(__FILE__,2).'/src/autoload.php');
use Twig\Pollen\Oscillated;
$server = new Oscillated('172.17.0.2',1227);
$server->on('CREATE',function() {
    echo "Osci server started at 172.17.0.2:1227".PHP_EOL;
});
$server->on('STATUS',function() {
    echo "Osci client request a status".PHP_EOL;
});
$server->on('GET_URL',function() {
    echo "Osci client request a url".PHP_EOL;
    return 'item.jd.com/1191532.html'.PHP_EOL;
});
$server->on('GET_URL_FILTER',function() {
    echo "Osci client request a url with filter".PHP_EOL;
    return 'item.jd.com/1191533.html'.PHP_EOL;
});
$server->listen();
