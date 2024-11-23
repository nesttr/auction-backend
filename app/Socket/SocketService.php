<?php

namespace App\Socket;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class SocketService
{
    private ClientInterface $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://9140-81-214-164-248.ngrok-free.app/',
        ]);
    }

    public function storeBid(string $uuid)
    {
        $this->client->post('/auction/bid', [
            'json' => [
                'uuid' => $uuid
            ],
        ]);
    }
}
