<?php
include(dirname(__DIR__).'/src/autoload.php');

use Twig\Process\Processd;
use Twig\Process\Process;

$process_manager = new Processd();

//create 10 process
for($i = 0; $i < 10; $i++) {
    $process = new Process(function() use ($i){
        echo "child process $i".PHP_EOL;
        sleep(5);
    });
    $process_manager->add($process);
}

$process_manager->run();
