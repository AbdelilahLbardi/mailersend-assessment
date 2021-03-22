<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function toArray($data)
    {
        return [
            'id' => $this->id,
            'sender' => $this->sender,
            'recipient' => $this->recipient,
            'subject' => $this->subject,
            'text_content' => $this->text_content,
            'html_content' => $this->html_content,
            'attachments' => new AttachmentCollection($this->attachments),
            'status' => new StatusResource($this->status),
            'history' => new StatusCollection($this->statuses),
            'created_at' => $this->created_at,
            'sent' => $this->when($this->sent_at != null, true, false),
            'sent_at' => $this->when($this->sent_at != null, $this->sent_at),

        ];
    }
}
