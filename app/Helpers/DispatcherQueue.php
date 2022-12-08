<?php

namespace App\Helpers;

use Vinelab\Bowler\Connection;
use Vinelab\Bowler\Dispatcher;
use Vinelab\Bowler\Publisher;

class DispatcherQueue
{
    public static function run(string $filename, string $filepath): void
    {
        $connection = new Connection('rabbitmq');
        $dispatcher = new Dispatcher($connection);
        $publisher = new Publisher($connection);

        $publisher->send($filepath, 'test');

//        $dispatcher->dispatch($filename, 'queue', $filepath);

    }
}
