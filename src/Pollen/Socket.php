<?php
namespace Twig\Pollen;
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
    }
}
