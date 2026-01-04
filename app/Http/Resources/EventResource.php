<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'description' => $this->description,
            'start_date' => $this->start_date?->toISOString(),
            'end_date' => $this->end_date?->toISOString(),
            'location' => $this->location,
            'category' => $this->category,
            'category_label' => config('calendar_event.categories')[$this->category] ?? $this->category,
            'organizer' => $this->organizer,
            'contact_email' => $this->contact_email,
            'contact_phone' => $this->contact_phone,
            'image_url' => $this->image_url,
            'status' => $this->status,
            'status_label' => config('calendar_event.statuses')[$this->status] ?? $this->status,
            'max_participants' => $this->max_participants,
            'registration_deadline' => $this->registration_deadline?->toISOString(),
            'is_public' => $this->is_public,
            'is_upcoming' => $this->is_upcoming,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
