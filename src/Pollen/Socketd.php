<?php
namespace Twig\Pollen;
use Twig\Event\Event;
use Twig\Event\Dispatcher as Dispatcher;
use Twig\Event\Listener as Listener;
use Twig\Pollen\Protocols\Sockets;

class Socketd extends Sockets implements Server {
    use Listener;
    use Dispatcher;

    private $socket;
    private $sockets = [];
    private $options = [
        'domain'=>   AF_INET,
        'type'  =>   SOCK_STREAM,
        'protocol'=> SOL_TCP,
        'block' => false
    ]; 
    protected $events = [
        'CREATE',
        'LISTEN',
        'CONNECT',
        'CONNECT_CLOSE',
        'READ',
        'WRITE',
        'CLOSE',
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
        $this->socket = socket_create($options['domain'],$options['type'],$options['protocol']);
    }
    public function listen() {
        $this->dispatch(new Event('CREATE'),$this->socket);
        $socket = $this->socket;
        socket_bind($socket,$this->address, $this->port);
        socket_listen($socket);
        $this->dispatch(new Event('LISTEN'),$this->socket);
        if (!$this->options['block']) {
            socket_set_nonblock($socket);
        }
        while(true) {
            if($con = socket_accept($socket)) {
                $this->dispatch(new Event('CONNECT'),$con);
                $this->sockets[] = $con;
            } else {
                $this->read();
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
                    $csocket = new Sockets($con,$read_buf);
                    $this->dispatch(new Event('READ'),$csocket);
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
        $this->dispatch(new Event('CLOSE'));
    }

    public function __destruct() {
        $this->close();
    }
}


