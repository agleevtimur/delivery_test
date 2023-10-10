<?php

namespace DTO;

use JsonSerializable;

class ErrorDateResponse implements JsonSerializable
{
    private string $message = "Заявки после 18:00 не принимаются";

    public function jsonSerialize(): array
    {
        return ['error' => $this->message];
    }
}