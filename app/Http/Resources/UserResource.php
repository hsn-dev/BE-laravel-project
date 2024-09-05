<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class UserResource extends ApiResource
{

    public static $wrap = 'user';

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
}
