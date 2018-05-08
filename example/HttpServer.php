<?php
include('src/autoload.php');

use Twig\Process\Process;
use Twig\Process\Processd;

/**
 * Create a http server
 */
function http_server() {
    while(true){
        echo "Wait for http request".PHP_EOL;
    }
}
$pm = new Processd("Twig[HttpServer-master]");
$process = new Process(function() {
    http_server();
},"Twig[HttpServer-Child]");
$pm->add($process);
$pm->run();
