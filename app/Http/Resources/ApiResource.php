<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\JsonResponse;

class ApiResource extends JsonResource
{
    protected $message;
    protected $status_code;

    public function __construct($resource, $status_code = 200, $message = null)
    {
        parent::__construct($resource);
        $this->message = $message;
        $this->status_code = $status_code;
    }

    public function withResponse(Request $request, JsonResponse $response): void
    {
        $wrap = static::$wrap ?? 'data';
        $data = [
            'success' => true,
            'message' => $this->message,
            $wrap => $response->getData()->$wrap,
        ];

        if ($this->message === null) {
            unset($data['message']);
        }

        $response->setStatusCode($this->status_code);
        $response->setData($data);
    }
}