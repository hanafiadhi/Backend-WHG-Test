<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'borrow_id' => $this->borrow_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'order_number' => $this->order_number,
            'status' => $this->status,
        ];
    }

    public function with(Request $request): array
    {
        return [
            'statusCode' => 200,
        ];
    }
}
