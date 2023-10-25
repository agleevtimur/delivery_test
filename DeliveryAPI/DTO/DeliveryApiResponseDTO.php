<?php

namespace DTO;

use JsonSerializable;

class DeliveryApiResponseDTO implements JsonSerializable
{
    public float $price;
    public string $date;
    public string $error;
    public string $apiName;
    public string $departureNumber;

    public function __construct(float $price, string $date, string $error, string $apiName, string $departureNumber)
    {
        $this->price = $price;
        $this->date = $date;
        $this->error = $error;
        $this->apiName = $apiName;
        $this->departureNumber = $departureNumber;
    }

    public function jsonSerialize(): array
    {
        return [
            'price' => $this->price,
            'date' => $this->date,
            'error' => $this->error,
            'departureNumber' => $this->departureNumber,
            'apiName' => $this->apiName
        ];
    }
}