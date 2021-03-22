<?php

namespace App\Jobs;

use App\Mail\Email;
use App\Models\Mail;
use App\Models\Status;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail as MailFacade;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Mail
     */
    public $mail;

    /**
     * Create a new job instance.
     *
     * @param Mail $mail
     */
    public function __construct(Mail $mail)
    {
        $this->mail = $mail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mail = $this->mail;

        MailFacade::send(new Email($mail));

        $status = Status::SENT;

        if (count(MailFacade::failures()) > 0) {
            $status = Status::FAILED;
        }

        $mail = tap($mail)->update([
            'sent_at' => now()
        ]);

        $mail->statuses()->create([
            'status' => $status
        ]);
    }
}
