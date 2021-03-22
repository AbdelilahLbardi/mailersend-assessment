<?php


namespace App\Services;


use App\Models\Attachment;
use Exception;
use Throwable;

class AttachmentService implements \App\Contracts\AttachmentService
{
    /**
     * @param $mailId
     * @param $attachments
     * @throws Throwable
     */
    public function upload($mailId, $attachments)
    {
        foreach ($attachments as $key => $file) {
            $uploaded = $file->store("attachments/{$mailId}");

            throw_if($uploaded == false, new Exception(__('Error while uploading files')));

            Attachment::query()->create([
                'mail_id' => $mailId,
                'name' => $uploaded
            ]);
        }
    }
}