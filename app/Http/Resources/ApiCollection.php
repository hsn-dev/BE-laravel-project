<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

class ApiCollection extends ResourceCollection
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

        if ($this->resource instanceof LengthAwarePaginator) {
            $data['meta'] = [
                'current_page' => $this->resource->currentPage(),
                'last_page' => $this->resource->lastPage(),
                'per_page' => $this->resource->perPage(),
                'total' => $this->resource->total(),
            ];
        }

        $response->setStatusCode($this->status_code);
        $response->setData($data);
    }
}