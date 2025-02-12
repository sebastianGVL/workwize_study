<?php

namespace App\Modules\Common\Interface\Http\Data;

readonly class BaseApiResponseData
{
    public function __construct(
        public ?array $data,
        public string $message,
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
