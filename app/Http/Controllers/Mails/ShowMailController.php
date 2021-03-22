<?php

namespace App\Http\Controllers\Mails;

use App\Http\Resources\MailResource;
use App\Models\Mail;

class ShowMailController
{
    /**
     * Handle the incoming request.
     * @param Mail $mail
     * @return MailResource
     */
    public function __invoke(Mail $mail)
    {
        return new MailResource($mail);
    }
}
