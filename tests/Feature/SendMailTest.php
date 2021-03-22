<?php

namespace Tests\Feature;

use App\Events\NewEmail;
use App\Mail\Email;
use App\Models\Attachment;
use App\Models\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail as MailFacade;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class SendMailTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_sender_is_required()
    {
        $this->sendNewMail($this->validParams(['sender' => null]))
            ->assertStatus(422)
            ->assertJsonPath('errors.sender.0', 'The sender field is required.');
    }


    public function test_sender_should_be_a_valid_email()
    {
        $this->sendNewMail($this->validParams(['sender' => 'invalid email @mail.com']))
            ->assertStatus(422)
            ->assertJsonPath('errors.sender.0', 'The sender must be a valid email address.');
    }


    public function test_recipient_is_required()
    {
        $this->sendNewMail($this->validParams(['recipient' => null]))
            ->assertStatus(422)
            ->assertJsonPath('errors.recipient.0', 'The recipient field is required.');
    }


    public function test_recipient_should_be_a_valid_email()
    {
        $this->sendNewMail($this->validParams(['recipient' => 'invalid email @mail.com']))
            ->assertStatus(422)
            ->assertJsonPath('errors.recipient.0', 'The recipient must be a valid email address.');
    }


    public function test_new_email_event_is_triggered()
    {
        Event::fake();

        $this->sendNewMail($this->validParams())->assertStatus(201);

        $mail = Mail::query()->first();

        Event::assertDispatched(function (NewEmail $event) use ($mail) {
            return $event->mail->id == $mail->id;
        });
    }


    public function test_attachments_size_is_controlled()
    {
        Storage::fake();

        $attachments = [
            'report.pdf' => UploadedFile::fake()->create('report.pdf', Attachment::MAX_FILE_SIZE + 1000),
            'landing-page.html' => UploadedFile::fake()->create('landing-page.html', Attachment::MAX_FILE_SIZE + 1000),
            'banner.png' => UploadedFile::fake()->create('banner.png', Attachment::MAX_FILE_SIZE),
        ];

        $response = $this->sendNewMail($this->validParams([ 'attachments' => $attachments ]))->assertStatus(422);

        $this->assertArrayHasKey('attachments.report.pdf', $response['errors']);
        $this->assertArrayHasKey('attachments.landing-page.html', $response['errors']);
        $this->assertArrayNotHasKey('attachments.banner.png', $response['errors']);
    }


    public function test_mail_attachments_are_uploaded()
    {
        Storage::fake();

        $attachments = [
            'report.pdf' => UploadedFile::fake()->create('report.pdf'),
            'landing-page.html' => UploadedFile::fake()->create('landing-page.html'),
            'banner.png' => UploadedFile::fake()->create('banner.png'),
        ];

        $this->sendNewMail($this->validParams([ 'attachments' => $attachments ]));

        $this->assertCount(3, Attachment::all());
        $this->assertCount(3, Mail::query()->first()->attachments);
    }


    public function test_new_mail_is_sent()
    {
        $this->withoutExceptionHandling();
        MailFacade::fake();

        $this->sendNewMail($this->validParams())->assertStatus(201);

        MailFacade::assertSent(Email::class);
    }


    public function test_mail_is_marked_as_sent_after_successful_sending()
    {
        MailFacade::fake();

        $this->sendNewMail($this->validParams())->assertStatus(201);

        MailFacade::assertSent(Email::class);

        $this->assertNotNull(Mail::query()->first()->sent_at);
        $this->assertTrue(Mail::query()->first()->status->sent());
    }


    public function test_new_mail_has_correct_text()
    {
        $this->withoutExceptionHandling();

        $this->sendNewMail($this->validParams())->assertStatus(201);

        $email = new Email(Mail::query()->first());

        $email->assertSeeInText('My new content');
    }


    public function test_new_mail_has_correct_html()
    {
        $this->sendNewMail($this->validParams())->assertStatus(201);

        $email = new Email(Mail::query()->first());

        $email->assertSeeInHtml("<h1>My html content</h1><p>This is my paragraph</p>");
    }


    public function test_new_mail_has_correct_attachments()
    {
        $this->sendNewMail($this->validParams())->assertStatus(201);

        $email = new Email(Mail::query()->first());

        $email->assertSeeInHtml("<h1>My html content</h1><p>This is my paragraph</p>");
    }

    /**
     * @param array $data
     * @return TestResponse
     */
    private function sendNewMail($data = []): TestResponse
    {
        return $this->postJson(route('mails.create'), $data);
    }

    /**
     * new Mail happy path
     *
     * @param array $data
     * @return array
     */
    private function validParams($data = [])
    {
        return array_merge([
            'sender' => 'sender@mailersend.com',
            'recipient' => 'recipient@mailersend.com',
            'subject' => 'New Email',
            'text_content' => 'My new content',
            'html_content' => "<h1>My html content</h1><p>This is my paragraph</p>"
        ], $data);
    }
}
