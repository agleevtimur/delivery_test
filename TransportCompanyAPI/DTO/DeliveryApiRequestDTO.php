<?php

namespace DTO;

class DeliveryApiRequestDTO
{
    public string $sourceKladr;
    public string $targetKladr;
    public float $weight;
    public string $companyName;
    public string $apiName;
    private function __construct() {}

    public static function fromJson(string $json): self
    {
        $data = json_decode($json, true);

        $dto = new self();
        $dto->targetKladr = $data['targetKladr'];
        $dto->sourceKladr = $data['sourceKladr'];
        $dto->weight = $data['weight'];

        if (isset($data['apiName'])) {
            $dto->apiName = $data['apiName'];
        }

        return $dto;
    }
}
