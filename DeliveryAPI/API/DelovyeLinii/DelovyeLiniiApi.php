<?php

namespace API\DelovyeLinii;

use API\DeliveryInterface;
use API\FastDeliveryRequestInterface;
use API\SlowDeliveryRequestInterface;
use DTO\DeliveryApiRequestDTO;
use DTO\DeliveryApiResponseDTO;
use DTO\TCApiFastDeliveryResponseDTO;
use DTO\TCApiSlowDeliveryResponseDTO;
use GuzzleHttp\Client;

class DelovyeLiniiApi implements SlowDeliveryRequestInterface, FastDeliveryRequestInterface
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function requestFastDelivery(DeliveryApiRequestDTO $data): TCApiFastDeliveryResponseDTO
    {
        $deloviyeLiniiDTO = DeloviyeLiniiRequestDTO::fromDeliveryApiRequest($data);

        $response = $this->client->post('fast', ['json' => $deloviyeLiniiDTO]);

        return TCApiFastDeliveryResponseDTO::fromDeloviyeLiniiJson($response->getBody()->getContents());
    }

    public function requestSlowDelivery(DeliveryApiRequestDTO $data): TCApiSlowDeliveryResponseDTO
    {
        $deloviyeLiniiDTO = DeloviyeLiniiRequestDTO::fromDeliveryApiRequest($data);

        $response = $this->client->post('slow', ['json' => $deloviyeLiniiDTO]);

        return TCApiSlowDeliveryResponseDTO::fromDeloviyeLiniiJson($response->getBody()->getContents());
    }
}
