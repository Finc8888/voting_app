<?php
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->overload(); // ! WARNING ! Don't use getenv() because it can't override Apache SetEnv values. Instead use $_SERVER