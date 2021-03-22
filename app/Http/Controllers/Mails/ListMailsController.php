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
        $mails = Mail::query()
            ->when(request('sender'), function ($query) {
                $query->where('sender', 'like', '%' . request('sender') . '%');
            })
            ->when(request('recipient'), function ($query) {
                $query->where('recipient', 'like', '%' . request('recipient') . '%');
            })
            ->when(request('subject'), function ($query) {
                $query->where('subject', 'like', '%' . request('subject') . '%');
            })
            ->paginate(20);

        return new MailCollection($mails);
    }
}
