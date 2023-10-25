<?php

namespace DTO;

class DeliveryApiRequestDTO
{
    public string $sourceKladr;
    public string $targetKladr;
    public float $weight;
    public string $departureNumber;
    public string $apiName;
    private function __construct() {}

    public static function manyFromJson(string $json): array
    {
        $data = json_decode($json, true);
        $result = [];

        foreach ($data as $item) {
            $dto = new self();
            $dto->targetKladr = $item['targetKladr'];
            $dto->sourceKladr = $item['sourceKladr'];
            $dto->weight = $item['weight'];
            $dto->departureNumber = $item['departureNumber'];
            $dto->apiName = $item['apiName'];

            $result[] = $dto;
        }

        return $result;
    }
}
