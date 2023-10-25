<?php

namespace API\PEK;

use API\FastDeliveryRequestInterface;
use API\SlowDeliveryRequestInterface;
use DTO\DeliveryApiRequestDTO;
use DTO\TCApiFastDeliveryResponseDTO;
use DTO\TCApiSlowDeliveryResponseDTO;
use GuzzleHttp\Client;

class PekApi implements FastDeliveryRequestInterface, SlowDeliveryRequestInterface
{

    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function requestFastDelivery(DeliveryApiRequestDTO $data): TCApiFastDeliveryResponseDTO
    {
        $pekDTO = PekRequestDTO::fromDeliveryApiRequestDTO($data);

        $response = $this->client->post('fast', ['json' => $pekDTO]);

        return TCApiFastDeliveryResponseDTO::fromPEKJson($response->getBody()->getContents());
    }

    public function requestSlowDelivery(DeliveryApiRequestDTO $data): TCApiSlowDeliveryResponseDTO
    {
        $pekDTO = PekRequestDTO::fromDeliveryApiRequestDTO($data);

        $response = $this->client->post('slow', ['json' => $pekDTO]);

        return TCApiSlowDeliveryResponseDTO::fromPEKJson($response->getBody()->getContents());
    }
}
