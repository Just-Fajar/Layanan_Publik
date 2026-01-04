<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VisitorResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'asal_daerah' => $this->asal_daerah,
            'institution' => $this->Institution,
            'purpose' => $this->purpose,
            'purpose_label' => config('buku_tamu.purpose_options')[$this->purpose] ?? $this->purpose,
            'notes' => $this->notes,
            'photo_url' => $this->photo_url,
            'visit_date' => $this->visit_date?->toISOString(),
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
