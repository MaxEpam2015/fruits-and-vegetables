<?php

declare(strict_types=1);

namespace App\Response;

class ApiResponse
{
    public function __construct(
        protected string $status = 'Success',
        protected string $message = '',
        protected mixed $data = [],
    ) {
    }

    /**
     * @return string[]
     */
    public function toArray(): array
    {
        $responseArray = [
            'status' => $this->status,
        ];
        if (!empty($this->message)) {
            $responseArray['message'] = $this->message;
        }
        if (!empty($this->data)) {
            $responseArray['data'] = $this->data;
        }

        return $responseArray;
    }
}
