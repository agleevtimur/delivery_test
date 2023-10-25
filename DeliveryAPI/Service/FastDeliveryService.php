<?php

namespace Service;

use API\FastDeliveryRequestInterface;
use DateInterval;
use DateTime;
use DTO\DeliveryApiRequestDTO;
use DTO\DeliveryApiResponseDTO;

class FastDeliveryService implements DeliveryStrategyInterface
{
    const DAYTIME_LIMIT = 18;

    /**
     * @param FastDeliveryRequestInterface $api
     * @param string $apiName
     * @param DeliveryApiRequestDTO $requestDTO
     * @return DeliveryApiResponseDTO
     */
    public function resolve($api, string $apiName, DeliveryApiRequestDTO $requestDTO): DeliveryApiResponseDTO
    {
        $fastDeliveryResponse = $api->requestFastDelivery($requestDTO);

        $dayPeriod = $fastDeliveryResponse->period;
        if (getdate()['hours'] > self::DAYTIME_LIMIT) {
            $dayPeriod++;
        }

        $date = (new DateTime())->add(new DateInterval("P{$dayPeriod}D"))->format('Y-m-d');

        return new DeliveryApiResponseDTO(
            $fastDeliveryResponse->price,
            $date,
            $fastDeliveryResponse->error,
            $apiName,
            $requestDTO->departureNumber
        );
    }
}