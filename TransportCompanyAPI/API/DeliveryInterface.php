<?php

namespace API;
use DTO\DeliveryApiRequestDTO;
use DTO\TCApiSlowDeliveryResponseDTO;
use DTO\TCApiFastDeliveryResponseDTO;

interface DeliveryInterface
{
    /**
     * Запрос в сервис транспортной компании на быструю доставку
     *
     * @param DeliveryApiRequestDTO $apiRequestData
     * @return TCApiFastDeliveryResponseDTO
     */
    public function fastDelivery(DeliveryApiRequestDTO $apiRequestData): TCApiFastDeliveryResponseDTO;

    /**
     * Запрос в сервис транспортной компании на быструю доставку
     *
     * @param DeliveryApiRequestDTO $apiRequestData
     * @return TCApiSlowDeliveryResponseDTO
     */
    public function slowDelivery(DeliveryApiRequestDTO $apiRequestData): TCApiSlowDeliveryResponseDTO;
}
