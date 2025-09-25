<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Admin
 */
class AdminResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => [
                'id' => $this->role->id,
                'code' => $this->role->code,
                'name' => $this->role->name,
                'all_permissions' => $this->role->all_permissions,
            ],
            'permissions' => $this->role->permissions->pluck('code'),
        ];
    }
}
