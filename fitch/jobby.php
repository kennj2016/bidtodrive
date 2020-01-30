<?php

//
// Add this line to your crontab file:
//
// * * * * * cd /path/to/project && php jobby.php 1>> /dev/null 2>&1
//

require_once __DIR__ . '/vendor/autoload.php';

$jobby = new \Jobby\Jobby();

$jobby->add('EndTimeAuction', array(
    'command' => 'php end_time_auction.php',
    'schedule' => '* * * * *',
    'output' => 'logs/endTimeAuction.log',
    'enabled' => true,
));

$jobby->run();
