<?php
namespace Twig\Pollen\Protocols;

abstract class Osci_v1 implements Protocol {
    public  const VERSION  = 1.0;
    public  const NAME     = 'OSCI';
    private const INVALID_FORMAT='Invalid protocol format';
    private $allowed_method = [
       'STATUS',
       'GET-URL',
       'GET-URL-FITLER'
    ];
    private $content;
    private $osci_method;
    private $osci_content;
    
    /**
     * @method process()
     *
     * Interpret the semantic of protocol conents and take practice basesd
     * on it's semantic
     */
    public function process() {
        if(!$this->valid()) {
            $this->write(self::INVALID_FORMAT.PHP_EOL);
            $this->close();
        }
        $pmethod = strtolower($this->osci_method);
        $this->pmethod($this->osci_content);
    }

    /**
     * @method parse()
     *
     * Interpret semantic parts of protocol
     */
    public function parse() {
        $explode = explode($this->content,'\ ');
        $this->osci_method = $explode[2];
        $this->osci_content =$explode[3];
    }

    /**
     * @method valid()
     * Check if content follows the rule of Osci_v1 protocol
     */
    public function valid() {
        $vvername = stripos($this->content,self::NAME.'/'.self::VERSION) === 0;
        $explode = explode($this->content,'\ '); 
        $vmethod  = in_array($explode[2],$this->allowed_method);
        if ($vvername && $vmethod) {
            return true;
        } 
        return false;
    }

    public abstract function status();
    public abstract function get_url(); 
    public abstract function get_url_filter();
}
