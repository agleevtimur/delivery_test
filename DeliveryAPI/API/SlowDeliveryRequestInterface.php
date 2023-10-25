<?php

namespace API;

use DTO\DeliveryApiRequestDTO;
use DTO\DeliveryApiResponseDTO;
use DTO\TCApiSlowDeliveryResponseDTO;

interface SlowDeliveryRequestInterface
{
    public function requestSlowDelivery(DeliveryApiRequestDTO $data): TCApiSlowDeliveryResponseDTO;
}