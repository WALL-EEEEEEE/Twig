<?php
namespace Twig\Pollen;
use Twig\Pollen\Protocols\Osci_v1 as Osci;

class Oscillated extends Osci implements Server  {
    private $socket;
    private $address;
    private $port;
    private $clients = [];

    public function __construct(string $address = '0.0.0.0', int $port=2237) {
        $this->socket = new Socketd($address, $port);
        $this->socket->on('CREATE',function($socket) {
            echo "Socket created :".$socket.PHP_EOL;
        });
        $this->socket->on('LISTEN',function($socket) {
            echo "Socket listens on:".$socket.PHP_EOL;
        });

        $this->socket->on('READ',function($socket) {
            echo "Received: ".PHP_EOL;
            $read = $socket->read();
            var_dump($read);
            if (strpos($read,'status') !== FALSE) {
                $status = $this->status();
                var_dump($status);
                $socket->write($status,1024);
            }
        });
        $this->socket->on('CONNECT',function($socket) {
            socket_getpeername($socket,$ip,$port);
            $this->clients[] = $ip.':'.$port;
        });
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

    public function status() {
        $status = 'Actived crawlers:'.PHP_EOL;
        $status.= implode($this->clients,"\r\n");
        $status.= "\r\n";
        return $status;
    }
}

