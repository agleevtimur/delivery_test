<?php

namespace Service;

use API\FastDeliveryRequestInterface;
use API\SlowDeliveryRequestInterface;
use DTO\DeliveryApiRequestDTO;
use DTO\DeliveryApiResponseDTO;

/**
 * Есть несколько видов доставки, соотвественно разные стратегии, которые выполняют одну задачу: получить данные от api ТК.
 * Но имеют разную реализацию.
 * С версии php 8.0 для параметра $api можно указать более жесткую типизацию. Он принимает одну из реализаций интерфейса для отправки запроса по api
 */
interface DeliveryStrategyInterface
{
    /**
     * @param FastDeliveryRequestInterface|SlowDeliveryRequestInterface $api
     * @param string $apiName
     * @param DeliveryApiRequestDTO $data
     * @return DeliveryApiResponseDTO
     */
    public function resolve($api, string $apiName, DeliveryApiRequestDTO $data): DeliveryApiResponseDTO;
}