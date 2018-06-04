<?php
include(dirname(__FILE__,2).'/src/autoload.php');
use Twig\Pollen\Oscillate;
for( $i =0 ; $i < 100; $i++ ) {
    $client = new Oscillate('172.17.0.2',1227);
    //var_dump($client->status());
    //var_dump($client->url());
    var_dump($client->url_filter('jd.com'));
}
