<?php
namespace Twig\Pollen;
use Twig\Pollen\Protocols\Osci_v1 as Osci;
use Twig\Event\Dispatcher as Dispatcher;
use Twig\Event\Listener as Listener;
use Twig\Event\Event as Event;

class Oscillated extends Osci implements Server  {
    use Dispatcher;
    use Listener;
    private $socket;
    private $address;
    private $port;
    private $clients = [];
    private $events = [
        'CREATE',
        'LISTEN',
        'CONNECT',
        'CONNECT_CLOSE',
        'CLOSE',
        'STATUS',
        'GET_URL',
        'GET_URL_FILTER',
        'PUT_URL'
    ];

    public function __construct(string $address = '0.0.0.0', int $port=2237) {
        $this->socket = new Socketd($address, $port);
        $this->socket->on('CREATE',function($socket) {
                $this->dispatch(new Event('CREATE'),$this);
        });
        $this->socket->on('LISTEN',function($socket) {
                $this->dispatch(new Event('LISTEN'),$this);
        });
        $this->socket->on('READ',function($socket) {
            $this->process($socket);
        });
        $this->socket->on('CONNECT',function($socket) {
            socket_getpeername($socket,$ip,$port);
            $this->clients[] = $ip.':'.$port;
            $this->dispatch(new Event('CONNECT'),$this);
        });
        $this->socket->on('CONNECT_CLOSE',function($socket) {
            $this->dispatch(new Event('CONNECT_CLOSE'),$this);
        });
    }

    public function listen() {
        $this->socket->listen();
    }

    public function close() {
        $this->socket->close();
        $this->dispatch(new Event('CLOSE'),$this);
    }

    public function __destruct() {
        $this->close();
    }

    public function status() {
        $status = '------------ CRAWLERS STATUS ----------------'.PHP_EOL;
        $status.= implode($this->clients,PHP_EOL);
        $status.= PHP_EOL;
        $status.= "---------------------------- ----------------".PHP_EOL;
        $this->dispatch(new Event('STATUS'), $this);
        return $status;
    }

    public function get_url_filter($domain) {
       $url = $this->dispatch(new Event('GET_URL_FILTER'),$this,$domain);
       return $url;
    }

    public function get_url() {
       $url = $this->dispatch(new Event('GET_URL'), $this);
       return $url;
    }

    public function put_url($url) {
       $url = $this->dispatch(new Event('PUT_URL'), $this,$url);
    }
}

