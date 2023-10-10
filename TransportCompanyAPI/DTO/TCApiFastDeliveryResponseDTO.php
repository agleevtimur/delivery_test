<?php

namespace DTO;

class TCApiFastDeliveryResponseDTO
{
    public float $price;
    public int $period;
    public string $error;

    private function __construct()
    {
    }

    public static function fromDeloviyeLiniiJson(string $json): self
    {
        $dto = new self();
        $data = json_decode($json, true);
        $dto->price = $data['price'];
        $dto->period = $data['period'];
        $dto->error = $data['error'];

        return $dto;
    }

    public static function fromPEKJson(string $json): self
    {
        $dto = new self();
        $data = json_decode($json, true);
        $dto->price = $data['cost'];
        $dto->period = $data['period'];
        $dto->error = $data['error'];

        return $dto;
    }
}
