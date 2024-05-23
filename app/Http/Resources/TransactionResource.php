<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
          'id'          => $this->id,
          'sender'      => new UserResource(User::find($this->sender_id)),
          'receiver'    => new UserResource(User::find($this->receiver_id)),
          'amount'      => $this->amount,
          'created_at'  => $this->created_at,
          'updated_at'  => $this->updated_at
        ];
    }
}
