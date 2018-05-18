<?php
namespace Twig\Pollen;
use Twig\Pollen\Protocols\Osci_v1 as Osci;

class Oscillated extends Osci implements Server  {
    private $socket;
    private $address;
    private $port;

    public function __construct(string $address = '0.0.0.0', int $port=2237) {
        $this->socket = new Socketd($address, $port);
    }
    public function listen() {
        $this->socket->listen();
    }

    public function close() {
        $this->socket->close();
    }

    public function write() {
    }
    public function __destruct() {
        $this->socket->close();
    }
}

