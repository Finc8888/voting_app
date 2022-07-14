<?php 
require_once('config.php');
$redisClient = new Predis\Client([
    "scheme" => "tcp",
    "host" => $_SERVER['REDIS_HOST'],
    "port" => $_SERVER['REDIS_PORT'],
]);
$responses = $redisClient->transaction()->get('test')->execute();

if(!empty($responses)) {
    echo "<h2>Test responses is : '$responses[0]'.</h2>";

}


