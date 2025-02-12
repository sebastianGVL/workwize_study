<?php

namespace App\Modules\Admin\User\Interface\Http\Data;

class BaseApiResponseData
{
    public function __construct(
        public readonly ?array $data,
        public readonly string $message,
    )
    {

    }

    public static function make(?array $data, string $message): self
    {
        return new self($data, $message);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'data' => $this->data,
            'message' => $this->message,
        ];
    }
}
