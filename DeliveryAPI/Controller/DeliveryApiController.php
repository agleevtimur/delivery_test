<?php

namespace Controller;

use DTO\DeliveryApiRequestDTO;
use DTO\DeliveryApiResponseDTO;
use Service\DeliveryStrategyInterface;
use Service\FastDeliveryService;
use Service\SlowDeliveryService;

class DeliveryApiController extends ControllerAbstract
{
    private array $apiContainer;
    private DeliveryStrategyInterface $deliveryStrategy;

    public function __construct(array $apiContainer, DeliveryStrategyInterface $deliveryStrategy)
    {
        $this->apiContainer = $apiContainer;
        $this->deliveryStrategy = $deliveryStrategy;
    }

    /**
     * По-скольку apiName в запросе может иметь значение "all", то пришлось передавать реальный apiName дальше по сервису и
     * присваивать это значение в ResponseDTO. Так как фронту необходимо знать от какой ТК пришли данные расчетов
     *
     * @return void
     */
    public function resolve()
    {
        $requestDTOList = DeliveryApiRequestDTO::manyFromJson($this->getJson());
        $result = [];

        /** @var DeliveryApiRequestDTO $requestDTO */
        foreach ($requestDTOList as $requestDTO) {
            if ($requestDTO->apiName === "all") {
                foreach ($this->apiContainer["all"] as $apiName => $api) {
                    $result[] = $this->deliveryStrategy->resolve($api, $apiName, $requestDTO);
                }
            } else {
                $result[] = $this->deliveryStrategy->resolve($this->apiContainer[$requestDTO->apiName], $requestDTO->apiName, $requestDTO);
            }
        }

        $this->dispatchJsonResponse($result);
    }
}