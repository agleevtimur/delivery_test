<?php

namespace API\PEK;

use DTO\DeliveryApiRequestDTO;
use JsonSerializable;

class PekRequestDTO implements JsonSerializable
{
    public string $sourcePoint;
    public string $targetPoint;
    public float $weight;

    private function __construct() {}

    public static function fromDeliveryApiRequestDTO(DeliveryApiRequestDTO $deliveryApiRequestDTO): self
    {
        $result = new self();
        $result->sourcePoint = $deliveryApiRequestDTO->sourceKladr;
        $result->targetPoint = $deliveryApiRequestDTO->targetKladr;
        $result->weight = $deliveryApiRequestDTO->weight;

        return $result;
    }

    public function jsonSerialize(): array
    {
        return [
            'sourcePoint' => $this->sourcePoint,
            'targetPoint' => $this->targetPoint,
            'weight' => $this->weight
        ];
    }
}