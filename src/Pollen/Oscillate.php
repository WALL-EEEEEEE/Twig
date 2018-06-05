<?php
namespace Twig\Pollen;
use Twig\Pollen\Socket;
use Twig\Pollen\Protocols\Osci_v1 as Osci;

<<<<<<< HEAD
class Oscillate extends Osci implements Client {
    private $socket;

    public function __construct($address,$port) {
        $this->socket = new Socket($address,$port);
    }
    /** 
     * @method status()
     * get status of crawlers from host
     */
    public function status() {
        $status_proto = 'OSCI/1.0 STATUS';
        $this->socket->write($status_proto,strlen($status_proto));
        $status = $this->socket->read();
        return $status;
    }
    /**
     * @method url()
     * get url from host
     */
    public function url() {
        return $this->get_url();
    }

    /**
     * @method url_filter()
     * get url filtered by domain from host
     */
    public function url_filter($domain) {
        return $this->get_url_filter($domain);
    }

    public function get_url() {
        $proto = 'OSCI/1.0 GET_URL';
        $this->socket->write($proto,strlen($proto));
        $url = $this->socket->read();
        return $url;
    }
    public function get_url_filter($domain) {
        $proto = 'OSCI/1.0 GET_URL_FILTER';
        $this->socket->write($proto,strlen($proto));
        $url = $this->socket->read();
        return $url;
=======
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
        return trim($response);
    }

    public function put_url($url) {
        $protocol = self::NAME.'/'.self::VERSION.' PUT_URL '.$url;
        $this->socket->write($protocol,strlen($protocol));
        $response =  $this->socket->read();
        return $response;
>>>>>>> 1bc8ec4b2d2a40c4b1631394172d0c3c9e3f21f4
    }
}
