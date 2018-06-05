<?php
namespace Twig\Pollen;
<<<<<<< HEAD
use Twig\Pollen\Client;
use Twig\Pollen\Protocols\Sockets;
use Twig\Event\Dispatcher as Dispatcher;
use Twig\Event\Listener as Listener;
use Twig\Event\Event as Event;

/**
 * class Socket
 *
 * Socket client
 *
 */
class Socket extends Sockets implements Client {
    private $socket;
    private $event = [
    ];
    public function __construct($address, $port, $socket_option = []) {
        if (empty($socket_option)) {
            $this->socket = socket_create(AF_INET,SOCK_STREAM,SOL_TCP);
        }
        $this->socket = socket_create(AF_INET,SOCK_STREAM,SOL_TCP);
        socket_connect($this->socket,$address,$port);
    }

    public function write(string $write, int $length) {
        return socket_write($this->socket, $write, $length);
    }

    public function read() {
        $revdata = [];
        while($rdata = socket_read($this->socket,1024,PHP_BINARY_READ)) {
            $revdata[] = $rdata;
        }
        return $revdata;
=======

use Twig\Pollen\Protocols\Sockets;

class Socket extends Sockets {
    private $address;
    private $port;
    private $socket;
    private $options = [
        'domain'=>   AF_INET,
        'type'  =>   SOCK_STREAM,
        'protocol'=> SOL_TCP,
        'block' => false
    ]; 

    public function __construct($address,$port,$socket_options = []) {
        $this->address = $address;
        $this->port    = $port;
        if(empty($options)) {
            $options = $this->options;
        } else {
            $options = array_merge($this->options,$socket_options);
        }
        $this->socket = socket_create($options['domain'],$options['type'],$options['protocol']);
    }

    public function read(int $size = 1024) {
        $data = '';
        while($content =  socket_read($this->socket,$size)) {
            $data.=$content;
        }
        return $data;
    }

    public function write(string $content, int $size) {
        socket_connect($this->socket,$this->address,$this->port);
        $size = socket_write($this->socket,$content,$size);
    }

    public function close() {
        socket_close($this->socket);
>>>>>>> 1bc8ec4b2d2a40c4b1631394172d0c3c9e3f21f4
    }
}
