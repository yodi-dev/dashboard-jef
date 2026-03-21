<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'email'        => $this->email,
            'phone'        => $this->phone,
            'package'      => $this->package,
            'location'     => $this->location,
            'booking_date' => $this->booking_date->format('d M Y, H:i'),
            'message'      => $this->message,
            'status'       => $this->status,
            'created_at'   => $this->created_at->format('d M Y'),
        ];
    }
}
