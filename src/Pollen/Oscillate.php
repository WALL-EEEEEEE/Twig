<?php
namespace Twig\Pollen;

use Twig\Pollen\Protocols\Osci_v1 as Osci;
use Twig\Pollen\Client;
use Twig\Pollen\Socket;

class Oscillate extends Osci  implements Client {
    private $socket;

    public function __construct($address,$port) {
        $this->socket = new Socket($address,$port);
    }

    public function status() {
        $protocol = self::NAME.'/'.self::VERSION.' STATUS';
        $this->socket->write($protocol,strlen($protocol));
        $response = $this->socket->read();
        return $response;
    }

    public function get_url() {
        $protocol = self::NAME.'/'.self::VERSION.' GET_URL';
        $this->socket->write($protocol,strlen($protocol));
        $response = $this->socket->read();
        return trim($response);
    }
    public function get_url_filter($domain) {
        $protocol = self::NAME.'/'.self::VERSION.' GET_URL_FILTER '.$domain;
        $this->socket->write($protocol,strlen($protocol));
        $response =  $this->socket->read();
        return $response;
    }

    public function put_url($url) {
        $protocol = self::NAME.'/'.self::VERSION.' PUT_URL '.$url;
        $this->socket->write($protocol,strlen($protocol));
        $response =  $this->socket->read();
        return $response;
    }
}
