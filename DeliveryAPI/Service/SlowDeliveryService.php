<?php

namespace Service;

use API\SlowDeliveryRequestInterface;
use DTO\DeliveryApiRequestDTO;
use DTO\DeliveryApiResponseDTO;

class SlowDeliveryService implements DeliveryStrategyInterface
{
    const BASE_PRICE = 150;

    /**
     * @param SlowDeliveryRequestInterface $api
     * @param string $apiName
     * @param DeliveryApiRequestDTO $requestDTO
     * @return DeliveryApiResponseDTO
     */
    public function resolve($api, string $apiName, DeliveryApiRequestDTO $requestDTO): DeliveryApiResponseDTO
    {
        $slowDeliveryResponse = $api->requestSlowDelivery($requestDTO);

        $price = self::BASE_PRICE * $slowDeliveryResponse->coefficient;

        return new DeliveryApiResponseDTO(
            $price,
            $slowDeliveryResponse->date,
            $slowDeliveryResponse->error,
            $apiName,
            $requestDTO->departureNumber
        );
    }
}