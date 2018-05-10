<?php
include(dirname(__FILE__,2).'/src/autoload.php');
use Twig\Pollen\Oscillated;
$server = new Oscillated('172.17.0.2',1227);
$server->listen();
