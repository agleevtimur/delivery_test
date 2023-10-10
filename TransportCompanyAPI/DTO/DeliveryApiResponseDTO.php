<?php

namespace DTO;

use DateInterval;
use DateTime;
use JsonSerializable;

class DeliveryApiResponseDTO implements JsonSerializable
{
    const BASE_PRICE = 150;
    public float $price;
    public string $date;
    public string $error;
    public string $apiName;

    private function __construct() {}

    public static function fromTCApiSlowDeliveryResponseDTO(TCApiSlowDeliveryResponseDTO $dto): self
    {
        $result = new self();
        $result->price = round(self::BASE_PRICE * $dto->coefficient, 2);
        $result->date = $dto->date;
        $result->error = $dto->error;

        return $result;
    }

    public static function fromTCApiFastDeliveryResponseDTO(TCApiFastDeliveryResponseDTO $dto): self
    {
        $result = new self();
        $result->price = $dto->price;
        $result->error = $dto->error;
        $result->date = (new DateTime())->add(new DateInterval("P{$dto->period}D"))->format('Y-m-d');

        return  $result;
    }

    public function jsonSerialize(): array
    {
        $res = [
            'price' => $this->price,
            'date' => $this->date,
            'error' => $this->error
        ];

        if (isset($this->apiName)) {
            $res['apiName'] = $this->apiName;
        }

        return $res;
    }
}