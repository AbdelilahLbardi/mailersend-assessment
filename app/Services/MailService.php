<?php


namespace App\Services;


use App\Models\Mail;

class MailService implements \App\Contracts\MailService
{
    /**
     * @param $data
     */
    public function create($data)
    {
        return Mail::query()->create($data)->markAsPosted();
    }
}