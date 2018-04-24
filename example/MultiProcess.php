<?php
include(dirname(__DIR__).'/src/autoload.php');

use Twig\Process\Processd;
use Twig\Process\Process;

$process_manager = new Processd();
$process = new Process(function() {
    echo "child process 1".PHP_EOL;
});

$process_manager->add($process);
$process_manager->run();
