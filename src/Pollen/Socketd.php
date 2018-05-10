<?php
namespace Twig\Pollen;

class Socketd implements Server {

    private $socket;
    private $options = [
        'domain'=>   AF_INET,
        'type'  =>   SOCK_STREAM,
        'protocol'=> SOL_TCP,
        'block' => false
    ]; 
    private $address;
    private $port;

    /**
     * @method __construct()
     * @param string $address  default to 0.0.0.0
     * @param string $port default to 4230
     * @param array  $options allow options of sockets, defaults to ['domain'=> AFINET, 'type'=> SOCK_STREAM, 'protocol'=> SOL_TCP ]
     *
     * Craft a socket pair
     */
    public function __construct(string $address = '0.0.0.0', int $port=4230, array $options = []) {
        $this->address = $address;
        $this->port    = $port;
        if(empty($options)) {
            $options = $this->options;
        } else {
            $options = array_merge($this->options,$options);
        }
        echo "Creating socket ...".PHP_EOL;
        $this->socket = socket_create($options['domain'],$options['type'],$options['protocol']);
    }
    public function listen() {
        $socket = $this->socket;
        socket_bind($socket,$this->address, $this->port);
        socket_listen($socket);
        if (!$this->options['block']) {
            socket_set_nonblock($socket);
        }
        echo "Listening on ".$this->socket.":".$this->port.PHP_EOL;
        while(true) {
            if($con = socket_accept($socket)) {
                while($read = socket_read($con,1024)) {
                    var_dump($read);
                }
            } else {
                sleep(1);
            }
       }
    }
    public function close() {
        socket_close($this->socket);
    }
    public function __destruct() {
        $this->close();
    }
}


