<?php

include(dirname(__DIR__).'/src/autoload.php');

use Twig\Process\Processd;
use Twig\Process\Process;
use Twig\Process\Shared;
$process_manager = new Processd('ProcessManager'); 
$process_manager->share(new Shared(['what\'s','your','name'])); // share data in parent process

//create 10 process
for($i = 0; $i < 10; $i++) {
    $process = new Process(function($process) use($i) {
        echo "child process $i".PHP_EOL;
        //get shared data
        $shared_data = $process->shared();
        var_dump($shared_data);
        sleep(5);
    },'Child'.$i); 
    $process_manager->add($process);
}

$process_manager->run();
