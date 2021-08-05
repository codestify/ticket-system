<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'status' => $this->status ? 'closed' : 'open',
            $this->mergeWhen($this->whenLoaded('user'), [
                'user_name' => $this->user->name,
                'user_email' => $this->user->email
            ]),
            'subject' => $this->subject,
            'content' => $this->content,
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}
