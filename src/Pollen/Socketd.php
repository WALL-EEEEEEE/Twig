<?php
namespace Twig\Pollen;

class Socketd implements Server {

    private $socket;
    private $sockets = [];
    private $options = [
        'domain'=>   AF_INET,
        'type'  =>   SOCK_STREAM,
        'protocol'=> SOL_TCP,
        'block' => false
    ]; 
    private $address;
    private $port;
    private $read_buf;

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
                $this->sockets[] = $con;
            } else {
                if ($read = $this->read()) {
                    var_dump($read);
                }
                usleep(1);
            }
       }
    }

    /**
     * @method read()
     * Read contents from sockets
     */
    public function read(int $length = 1024, int $type = PHP_BINARY_READ) {
        foreach($this->sockets as $con) {
            socket_set_nonblock($con);
            while($read = socket_read($con, $length, $type)) {
                if ($read) {
                    $this->read_buf[(int)$con]  = $read;
                    $read_buf = $this->read_buf;
                    $this->read_buf = [];
                    return $read_buf;
                } else {
                    return false;
                }
            }
            usleep(1);
        }
    }

    public function close() {
        socket_close($this->socket);
    }
    public function __destruct() {
        $this->close();
    }
}


