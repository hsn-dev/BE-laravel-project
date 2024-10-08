<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class TaskResource extends ApiResource
{

    public static $wrap = 'task';

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'desc' => $this->desc,
            'status' => $this->status,
            'user' => $this->whenLoaded('user', new UserResource($this->user)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
