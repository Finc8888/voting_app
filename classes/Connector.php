<?php 
namespace Connector;
use Predis\Client as PredisClient;
class Connector {
    private $host;
    private $port;
    private $scheme;
    public function __construct($host, $port, $scheme = "tcp")
    {
        $this->port = $port;
        $this->host = $host;
        $this->scheme = "tcp";
        $this->client = new PredisClient([
            "scheme" => $this->scheme,
            "host" => $this->host,
            "port" => $this->port,
        ]);
    }

    public function getClient() {
        return $this->client;
    }

}


