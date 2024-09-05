<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class TaskCollection extends ApiCollection
{
    public static $wrap = 'tasks';

    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}