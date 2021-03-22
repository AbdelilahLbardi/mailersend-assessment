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
        $data['html_content'] = clean($data['html_content']);

        return Mail::query()->create($data)->markAsPosted();
    }
}