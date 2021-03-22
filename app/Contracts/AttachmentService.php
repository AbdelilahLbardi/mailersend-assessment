<?php


namespace App\Contracts;


interface AttachmentService
{

    /**
     * @param $mailId
     * @param $attachments
     */
    public function upload($mailId, $attachments);
}