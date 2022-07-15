<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once('classes/Connector.php');

use \Connector\Connector;

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->overload(); // ! WARNING ! Don't use getenv() because it can't override Apache SetEnv values. Instead use $_SERVER
$redisClient = new Connector($_SERVER['REDIS_HOST'],$_SERVER['REDIS_PORT']);