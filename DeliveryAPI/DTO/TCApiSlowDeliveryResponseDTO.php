<?php

namespace DTO;

/**
 * DTO для обработки ответа от api медленных доставок.
 * На первый взгляд кажется, что сущность избыточная, однако судя по ТЗ все ответы от api ТК можно привести к этому виду
 */

class TCApiSlowDeliveryResponseDTO
{
    public float $coefficient;
    public string $date;
    public string $error;

    private function __construct() {}

    public static function fromDeloviyeLiniiJson(string $json): self
    {
        $dto = new self();
        $data = json_decode($json, true);

        $dto->coefficient = $data['coefficient'];
        $dto->date = $data['date'];
        $dto->error = $data['error'];

        return $dto;
    }

    public static function fromPEKJson(string $json): self
    {
        $dto = new self();
        $data = json_decode($json, true);

        $dto->coefficient = $data['multiplier'];
        $dto->date = $data['date'];
        $dto->error = $data['error'];

        return $dto;
    }
}