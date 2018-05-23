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
            echo "Socket created :".PHP_EOL;
        });
        $this->socket->on('LISTEN',function($socket) {
            echo "Socket listens on:".$socket->getAddress().':'.$socket->getPort().PHP_EOL;
        });
        $this->socket->on('READ',function($socket) {
            $this->process($socket);
        });
        $this->socket->on('CONNECT',function($socket) {
            socket_getpeername($socket,$ip,$port);
            $this->clients[] = $ip.':'.$port;
        });
        $this->socket->on('CONNECT_CLOSE',function($socket) {
            echo "Socket connection close ...".PHP_EOL;
        });
    }

    public function listen() {
        $this->socket->listen();
    }

    public function close() {
        $this->socket->close();
    }

    public function __destruct() {
        $this->close();
    }

    public function status() {
        $status = '------------ CRAWLERS STATUS ----------------'.PHP_EOL;
        $status.= implode($this->clients,PHP_EOL);
        $status.= PHP_EOL;
        $status.= "---------------------------- ----------------".PHP_EOL;
        return $status;
    }

    public function get_url_filter($domain) {
        echo 'Filter domain'.PHP_EOL;
        return 'item.jd.com/11916.html';
    }

    public function get_url() {
        return 'item.jd.com/11916.html';
    }
}

