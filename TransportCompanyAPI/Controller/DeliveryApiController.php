<?php

namespace Controller;

use API\DeliveryInterface;
use DateInterval;
use DateTime;
use DTO\DeliveryApiRequestDTO;
use DTO\DeliveryApiResponseDTO;
use DTO\ErrorDateResponse;

class DeliveryApiController extends ControllerAbstract
{
    private array $apiContainer;

    public function __construct(array $apiContainer)
    {
        $this->apiContainer = $apiContainer;
    }

    public function calculateFastDeliveryPrice()
    {
//        if (getdate()['hours'] > 18) {
//            $this->dispatchJsonResponse(new ErrorDateResponse());
//        }

        $deliveryApiDTO = DeliveryApiRequestDTO::fromJson($this->getJson());
        $apis = isset($deliveryApiDTO->apiName) ?
            [$deliveryApiDTO->apiName => $this->apiContainer[$deliveryApiDTO->apiName]] :
            $this->apiContainer;

        $result = [];
        foreach ($apis as $apiName => $api) {
            /** @var DeliveryInterface $api */
            $response = $api->fastDelivery($deliveryApiDTO);
            $resultTemp = DeliveryApiResponseDTO::fromTCApiFastDeliveryResponseDTO($response);
            $resultTemp->apiName = $apiName;

            $result[] = $resultTemp;
        }

        $this->dispatchJsonResponse($result);
    }

    public function calculateSlowDeliveryCoefficient()
    {
        $deliveryApiDTO = DeliveryApiRequestDTO::fromJson($this->getJson());
        $apis = isset($deliveryApiDTO->apiName) ?
            [$deliveryApiDTO->apiName => $this->apiContainer[$deliveryApiDTO->apiName]] :
            $this->apiContainer;

        $result = [];
        foreach ($apis as $apiName => $api) {
            /** @var DeliveryInterface $api */
            $response = $api->slowDelivery($deliveryApiDTO);
            $resultTemp = DeliveryApiResponseDTO::fromTCApiSlowDeliveryResponseDTO($response);
            $resultTemp->apiName = $apiName;

            $result[] = $resultTemp;
        }

        $this->dispatchJsonResponse($result);
    }
}