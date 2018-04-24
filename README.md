# Twig

&ensp;&ensp;&ensp;&ensp;**Twig** is a distributed framework, which designed for high performance application development. It is just an analogue like [swoole](https://github.com/swoole/swoole-src), [workerman](https://github.com/walkor/Workerman), [zanphp](https://github.com/youzan/zanphp).

# Introduction

&ensp;&ensp;&ensp;&ensp;**Twig** is derived from [Pider](git@github.com:duanqiaobb/pider.git)--A distributed, multi-processes spider framework. It facilitates `Pider`'s distribution and muli-process features.

# Requirements

+ php7.1(or above)
+ pcntl
+ posix

# Usage
&ensp;&ensp;&ensp;&ensp;First and all, `autoload.php` file under `src` directory need to be included to solve all dependencies.

## MultiProcess

```php
<?php
include(dirname(__DIR__).'/src/autoload.php');

use Twig\Process\Processd;
use Twig\Process\Process;

$process_manager = new Processd();

//10 process is crafted
for($i = 0; $i < 10; $i++) {
    $process = new Process(function() {
        echo "child process 1".PHP_EOL;
        sleep(5);
    });
    $process_manager->add($process);
}

$process_manager->run();
```

## Customize process name

&ensp;&ensp;&ensp;&ensp;By default, Master process and Child process will be populated by default predefined name in `Twig`. Master process claims as `twig(master)` by default, Child process is `twig(child-pid)` predefined (`pid` is process id owned to child process ). However, you can customiz your name in program.

```php
<?php

include(dirname(__DIR__).'/src/autoload.php');

use Twig\Process\Processd;
use Twig\Process\Process;

$process_manager = new Processd('ProcessManager'); //Define name of master process

//create 10 process
for($i = 0; $i < 10; $i++) {
    $process = new Process(function() {
        echo "child process 1".PHP_EOL;
        sleep(5);
    },'Child'.$i); //Define name of child processes
    $process_manager->add($process);
}

$process_manager->run();
```

&ensp;&ensp;&ensp;&ensp; If you want to display your defined name with child pid, `pid` placehold can faciliate.

```php
include(dirname(__DIR__).'/src/autoload.php');

use Twig\Process\Processd;
use Twig\Process\Process;

$process_manager = new Processd('ProcessManager'); //Define name of master process

//create 10 process
for($i = 0; $i < 10; $i++) {
    $process = new Process(function() {
        echo "child process 1".PHP_EOL;
        sleep(5);
    },'Child'.$i.'[pid]'); //Define name of child processes
    $process_manager->add($process);
}

$process_manager->run();
```

Note:
> You can debug it by using `ps` or `top`("c" to switch to command name display). 

## Daemon process

&ensp;&ensp;&ensp;&ensp; `Twig` also supplies  a eaiser way to create daemon processes. 

```
<?php

include(dirname(__DIR__).'/src/autoload.php');

use Twig\Process\Processd;
use Twig\Process\Process;

$process_manager = new Processd('ProcessManager',true); //true set daemon process mode, vice verse

//create 10 process
for($i = 0; $i < 10; $i++) {
    $process = new Process(function() {
        echo "child process 1".PHP_EOL;
        sleep(5);
    },'Child'.$i); //Define name of child processes
    $process_manager->add($process);
}

$process_manager->run();
```

## IPC with shared memory
&ensp;&ensp;&ensp;&ensp; `Twig` just support simple IPC method now.`Shared Memory` is the only way available current.

+ Data from parent 

```php
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
```
+ Data from childs

```php
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
        $process->feedback(new Shared(['I am child '.$i]));//Emit data from childs
        sleep(5);
    },'Child'.$i); 
    $process_manager->add($process);
}

$process_manager->run();
var_dump($process_manager->feedbacks()); //Received data from childs
```

## Contribution

&ensp;&ensp;&ensp;&ensp;If you have any ideas, please emit an issue or post a pull request.
