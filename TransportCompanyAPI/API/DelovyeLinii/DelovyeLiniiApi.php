<?php

namespace API\DelovyeLinii;

use API\DeliveryInterface;
use DTO\DeliveryApiRequestDTO;
use DTO\TCApiFastDeliveryResponseDTO;
use DTO\TCApiSlowDeliveryResponseDTO;
use GuzzleHttp\Client;
use Repository\PriceHistoryRepository;

class DelovyeLiniiApi implements DeliveryInterface
{
    private PriceHistoryRepository $repository;
    private Client $client;

    public function __construct(PriceHistoryRepository $repository, Client $client)
    {
        $this->repository = $repository;
        $this->client = $client;
    }

    public function fastDelivery(DeliveryApiRequestDTO $apiRequestData): TCApiFastDeliveryResponseDTO
    {
        $deloviyeLiniiDTO = DeloviyeLiniiRequestDTO::fromDeliveryApiRequest($apiRequestData);

        $response = $this->client->post('fast', ['json' => $deloviyeLiniiDTO]);

        return TCApiFastDeliveryResponseDTO::fromDeloviyeLiniiJson($response->getBody()->getContents());
    }

    public function slowDelivery(DeliveryApiRequestDTO $apiRequestData): TCApiSlowDeliveryResponseDTO
    {
        $deloviyeLiniiDTO = DeloviyeLiniiRequestDTO::fromDeliveryApiRequest($apiRequestData);

        $response = $this->client->post('slow', ['json' => $deloviyeLiniiDTO]);

        return TCApiSlowDeliveryResponseDTO::fromDeloviyeLiniiJson($response->getBody()->getContents());
    }

    /**
     * Для демонстрации работы приложения вместо сетевого запроса в сервис транспортной компании
     * используюстя подготовленные данные из БД
     *
     * @param DeliveryApiRequestDTO $apiRequestData
     * @return float[]|int[]|string[]
     */
    public function fastDeliveryV2(DeliveryApiRequestDTO $apiRequestData): array
    {

        $logisticData = $this->repository->getByKladrsAndCompanyName(
            $apiRequestData->sourceKladr,
            $apiRequestData->targetKladr,
            $apiRequestData->companyName
        );

        if ($logisticData === null) {
            return [
                'error' => 'неизвестные данные'
            ];
        }

        return [
            'price' => $logisticData->getBasePrice() * $apiRequestData->weight
        ];
    }

    /**
     * Для демонстрации работы приложения вместо сетевого запроса в сервис транспортной компании
     * используюстя подготовленные данные из БД
     *
     * @param DeliveryApiRequestDTO $apiRequestData
     * @return float[]|int[]|string[]
     */
    public function slowDeliveryV2(DeliveryApiRequestDTO $apiRequestData): array
    {
        $logisticData = $this->repository->getByKladrsAndCompanyName(
            $apiRequestData->sourceKladr,
            $apiRequestData->targetKladr,
            $apiRequestData->companyName
        );

        if ($logisticData === null) {
            return [
                'error' => 'неизвестные данные'
            ];
        }

        return [
            'coefficient' => $logisticData->getBaseCoefficient() * $apiRequestData->weight
        ];
    }
}
