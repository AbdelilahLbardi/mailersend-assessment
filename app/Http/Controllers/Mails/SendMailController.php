<?php

namespace App\Http\Controllers\Mails;

use App\Contracts\AttachmentService;
use App\Contracts\MailService;
use App\Events\NewEmail;
use App\Http\Controllers\Controller;
use App\Http\Resources\MailResource;
use App\Models\Attachment;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Throwable;

class SendMailController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param MailService $mailService
     * @param AttachmentService $attachmentService
     * @return MailResource|Application|ResponseFactory|Response
     */
    public function __invoke(MailService $mailService, AttachmentService $attachmentService)
    {
        $data = request()->validate([
            'sender' => 'required|email',
            'recipient' => 'required|email',
            'subject' => 'sometimes',
            'text_content' => 'sometimes',
            'html_content' => 'sometimes',
            'attachments.*' => 'sometimes|file|max:' . Attachment::MAX_FILE_SIZE,
        ]);

        DB::beginTransaction();

        try {

            $mail = $mailService->create( Arr::except($data, 'attachments') );

            $attachmentService->upload($mail->id, request()->file('attachments', []));

        } catch (Throwable $e) {
            DB::rollBack();

            return response(['message' => $e->getMessage()], 422);
        }

        DB::commit();

        event(new NewEmail($mail));

        return new MailResource($mail);
    }
}
