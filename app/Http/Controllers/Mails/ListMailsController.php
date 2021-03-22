<?php

namespace App\Http\Controllers\Mails;

use App\Http\Resources\MailCollection;
use App\Models\Mail;
use Illuminate\Database\Eloquent\Builder;

class ListMailsController
{
    /**
     * Handle the incoming request.
     *
     */
    public function __invoke()
    {
        $mails = Mail::query()
            ->when(request('sender'), function (Builder $query) {
                $query->where('sender', 'like', '%' . request('sender') . '%');
            })
            ->when(request('recipient'), function (Builder $query) {
                $query->where('recipient', 'like', '%' . request('recipient') . '%');
            })
            ->when(request('subject'), function (Builder $query) {
                $query->where('subject', 'like', '%' . request('subject') . '%');
            })
            ->when(request('status') && request('status') != 0, function (Builder $query) {
                $query->whereHas(
                    'status', function (Builder $query) {
                        $query->where('status', 'like', request('status'));
                    });
            })
            ->latest()
            ->paginate(20)
            ->appends(request()->except('page'));

        return new MailCollection($mails);
    }
}
