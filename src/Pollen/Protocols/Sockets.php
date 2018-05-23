<?php
namespace Twig\Pollen\Protocols;
use Twig\Event\Event;
use Twig\Event\Dispatcher as Dispatcher;
use Twig\Event\Listener as Listener;

class Sockets implements Protocol {
    use Listener;
    use Dispatcher;

    public const NAME = "SOCKETS";
    private $csocket;
    private $read_buf;
    protected $events = [
        'CLOSE',
    ];

    public function __construct($socket,$read) {
        $this->csocket = $socket;
        $this->read_buf = $read;
    }
    public function write(string $write, int $length) {
        socket_write($this->csocket, $write, $length);
    }

    public function read() {
        return array_values($this->read_buf)[0];
    }

    public function close() {
        $socket_id = (int)$this->csocket;
        socket_close($this->csocket);
        $this->dispatch(new Event('CLOSE'),$socket_id);
    }
}
