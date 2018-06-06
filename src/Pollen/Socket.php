<?php
namespace Twig\Pollen;
use Twig\Pollen\Client;
use Twig\Pollen\Protocols\Sockets;

class Socket extends Sockets implements Client{
    private $address;
    private $port;
    private $socket;
    private $options = [
        'domain'=>   AF_INET,
        'type'  =>   SOCK_STREAM,
        'protocol'=> SOL_TCP,
        'block' => false
    ]; 

    public function __construct($address,$port,$socket_options = []) {
        $this->address = $address;
        $this->port    = $port;
        if(empty($options)) {
            $options = $this->options;
        } else {
            $options = array_merge($this->options,$socket_options);
        }
        $this->socket = socket_create($options['domain'],$options['type'],$options['protocol']);
    }

    public function read(int $size = 1024) {
        $data = '';
        while($content =  socket_read($this->socket,$size)) {
            $data.=$content;
        }
        return $data;
    }

    public function write(string $content, int $size) {
        socket_connect($this->socket,$this->address,$this->port);
        $size = socket_write($this->socket,$content,$size);
    }

    public function close() {
        socket_close($this->socket);
    }
}
