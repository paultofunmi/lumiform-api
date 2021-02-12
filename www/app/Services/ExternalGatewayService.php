<?php

namespace App\Services;

/**
 * Class ExternalGatewayService
 * @package App\Services
 */

use App\Exceptions\APIException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class ExternalGatewayService {

    private Client $client;

    public function __construct() {
        $this->client = new Client();
    }

    public function makeGETRequest(string $url): ResponseInterface {
        try {
            return $this->client->request('GET', $url);
        } catch (GuzzleException $e) {
            throw new APIException("ExternalService Request to url: " . $url . " failed due to " . $e->getMessage());
        }
    }
}
