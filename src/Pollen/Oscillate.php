<?php
namespace Twig\Pollen;
use Twig\Pollen\Socket;
use Twig\Pollen\Protocols\Osci_v1 as Osci;

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
    }
}
