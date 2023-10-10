<?php

namespace API\PEK;

use API\DeliveryInterface;
use API\DelovyeLinii\DeloviyeLiniiRequestDTO;
use DTO\DeliveryApiRequestDTO;
use DTO\TCApiFastDeliveryResponseDTO;
use DTO\TCApiSlowDeliveryResponseDTO;
use GuzzleHttp\Client;

class PekApi implements DeliveryInterface
{

    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function fastDelivery(DeliveryApiRequestDTO $apiRequestData): TCApiFastDeliveryResponseDTO
    {
        $pekDTO = PekRequestDTO::fromDeliveryApiRequestDTO($apiRequestData);

        $response = $this->client->post('fast', ['json' => $pekDTO]);

        return TCApiFastDeliveryResponseDTO::fromPEKJson($response->getBody()->getContents());
    }

    public function slowDelivery(DeliveryApiRequestDTO $apiRequestData): TCApiSlowDeliveryResponseDTO
    {
        $pekDTO = PekRequestDTO::fromDeliveryApiRequestDTO($apiRequestData);

        $response = $this->client->post('slow', ['json' => $pekDTO]);

        return TCApiSlowDeliveryResponseDTO::fromPEKJson($response->getBody()->getContents());
    }
}
