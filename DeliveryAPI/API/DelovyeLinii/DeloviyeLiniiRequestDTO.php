<?php

namespace API\DelovyeLinii;

use DTO\DeliveryApiRequestDTO;
use JsonSerializable;

class DeloviyeLiniiRequestDTO implements JsonSerializable
{
    public string $source;
    public string $target;

    private function __construct() {}

    public static function fromDeliveryApiRequest(DeliveryApiRequestDTO $apiRequestDTO): self
    {
        $dto = new self();
        $dto->source = $apiRequestDTO->sourceKladr;
        $dto->target = $apiRequestDTO->targetKladr;

        return $dto;
    }

    public function jsonSerialize(): array
    {
        return [
            'source' => $this->source,
            'target' => $this->target
        ];
    }
}
