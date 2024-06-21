<?php

namespace App\Http\Resources\Api\V1\Users;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class UsersCollection extends ResourceCollection
{
    public function toArray(Request $request): Collection
    {
        return $this->collection->map(fn($u) => new UserResource($u));
    }
}
