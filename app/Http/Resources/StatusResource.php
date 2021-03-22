<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'status' => $this->status,
            'label' => $this->getStatusLabel(),
            'created_at' => $this->created_at,
        ];
    }

    private function getStatusLabel()
    {
        if ($this->posted()) {
            return __('Posted');
        } elseif ($this->sent()) {
            return __('Sent');
        }

        return __('Failed');
    }
}
