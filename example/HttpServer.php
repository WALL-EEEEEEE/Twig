<?php
<<<<<<< HEAD
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
=======
include(__DIR__."/../src/autoload.php");
use Twig\Process\Processd;
use Twig\Process\Process;

function http_server($address,$port) {
    //init a socket 
    $http_respone  = "";
    $socket = socket_create(AF_INET,SOCK_STREAM, 0); 
    if ($socket < 0) {
        echo "Failed to create socket: ".socket_strerror($sock)."\n";
        exit();
    }
    //bind port and address
    $ret = socket_bind($socket,$address, $port);
    if ($ret < 0) {
        echo "Failed to bind socket:".socket_strerror($ret)."\n";
        exit();
    }
    $ret = socket_listen($socket,0);
    if ($ret < 0) {
        echo "Failed to listen to socket".socket_strerror($ret)."\n";
        exit();
    }
    socket_set_nonblock($socket);;
    socket_set_option($socket,SOL_SOCKET, SO_REUSEADDR,1);
    echo "Listen on: ".$address.":".$port.PHP_EOL;
    echo "Waiting for connections ...".PHP_EOL;
    while(true) {
        $connection = @socket_accept($socket);
        if ($connection === false) 
        {
            usleep(100);
        } else if ($connection > 0)  {
            interact($connection);
        } else  {
            echo "Error: ".socket_strerror($connection);
            die;
        }
    }
}

function interact($socket) {
    $http_get = "GET / HTTP/1.1<br/>";
    echo "Connection connected".PHP_EOL;
    echo "Receive ... ".PHP_EOL;
    while($rev = socket_read($socket,1024)){
        if (strpos($http_get,$rev) >= 0) {
            $response = <<<EOL
HTTP/1.1 200 OK

EOL;
            socket_write($socket,$response);
            socket_close($socket);
            break;
        } else {
            var_dump($rev);
        }
    } 
}

$pm = new Processd("Twig(HttpServer-master)");
$process = new Process(function () {
    http_server('127.0.0.1','1182');
},"Twig(HttpServer-client)");
$pm->add($process);
$pm->run();

>>>>>>> 5ac0648ebb4f3b7a2a4064a25fb4373f86e7c444
