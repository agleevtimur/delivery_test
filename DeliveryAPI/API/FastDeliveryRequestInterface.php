<?php

namespace API;

use DTO\DeliveryApiRequestDTO;
use DTO\DeliveryApiResponseDTO;
use DTO\TCApiFastDeliveryResponseDTO;

interface FastDeliveryRequestInterface
{
    public function requestFastDelivery(DeliveryApiRequestDTO $data): TCApiFastDeliveryResponseDTO;
}