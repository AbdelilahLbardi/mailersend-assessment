<?php

namespace App\Http\Controllers\Mails;

use App\Http\Resources\MailCollection;
use App\Models\Mail;

class ListMailsController
{
    /**
     * Handle the incoming request.
     *
     */
    public function __invoke()
    {
        return new MailCollection(Mail::query()->paginate(20));
    }
}
