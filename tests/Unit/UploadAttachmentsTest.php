<?php

namespace Tests\Unit;

use App\Models\Attachment;
use App\Models\Mail;
use App\Services\AttachmentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadAttachmentsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @var AttachmentService
     */
    private $attachmentService;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->attachmentService = app(AttachmentService::class);
    }

    public function test_upload_attachments()
    {
        $this->withoutExceptionHandling();

        $mail = Mail::factory()->create();

        Storage::fake();

        $this->assertCount(0, Attachment::all());

        $this->attachmentService->upload($mail->id, [
            'report.pdf' => UploadedFile::fake()->create('report.pdf'),
            'landing-page.html' => UploadedFile::fake()->create('landing-page.html'),
            'banner.png' => UploadedFile::fake()->create('banner.png'),
        ]);

        $mail->refresh()->attachments->each(function ($attachment) {
            Storage::assertExists($attachment->name);
        });

        $this->assertCount(3, $mail->refresh()->attachments);
    }



}
