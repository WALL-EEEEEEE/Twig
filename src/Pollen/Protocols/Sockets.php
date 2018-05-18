<?php
namespace Twig\Pollen\Protocols;

class Sockets implements Protocol {
    public const NAME = "SOCKETS";
    private $socket;
    private $read_buf;
    public function __construct($socket,$read) {
        $this->socket = $socket;
        $this->read_buf = $read;
    }
    public function write(string $write, int $length) {
        socket_write($this->socket, $write, $length);
    }

    public function read() {
        return array_values($this->read_buf)[0];
    }
}
