# Twig

&ensp;&ensp;&ensp;&ensp;**Twig** is a distributed framework, which designed for high performance application development. It is just an analogue like [swoole](https://github.com/swoole/swoole-src), [workerman](https://github.com/walkor/Workerman), [zanphp](https://github.com/youzan/zanphp).

# Introduction

&ensp;&ensp;&ensp;&ensp;**Twig** was derived from [Pider](git@github.com:duanqiaobb/pider.git)--A distributed, multi-processes spider framework. It facilitates `Pider` distribution and muli-process features.

# Requirements

+ php7.1(or above)
+ pcntl
+ posix

# Usage
&ensp;&ensp;&ensp;&ensp;First and all, `autoload.php` file under `src` directory need to be included to solve all the dependency.

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

&ensp;&ensp;&ensp;&ensp;By default, Master process and Child process will be populated by predefined default name in `Twig`.Master process claimed as `twig(master)` by default, Child process is `twig(child-pid)` by default (`pid` is process id owned to child process ). However, you can customized your name in program.

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
> You can debug it by using `ps` or `top`("c" to switch on command name display). 
