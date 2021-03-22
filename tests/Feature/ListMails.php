<?php

namespace Tests\Feature;

use App\Models\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListMails extends TestCase
{
    use RefreshDatabase;

    public function test_i_can_list_emails()
    {
        Mail::factory()->count(10)->create();

        $this->getJson(route('mails.index'))->assertJsonCount(10, 'data');
    }

    public function test_emails_are_paginated()
    {
        Mail::factory()->count(30)->create();

        $json = $this->getJson(route('mails.index'))
            ->assertJsonPath('meta.total', 30)
            ->json('links');

        $this->assertNotNull($json['next']);
    }

    public function test_filtering_emails_by_sender()
    {
        Mail::factory()->count(5)->create([
            'sender' => 'senderA@mail.com'
        ]);

        Mail::factory()->count(3)->create([
            'sender' => 'senderB@mail.com'
        ]);

        $this->getJson(route('mails.index', ['sender' => 'senderB@mail.com']))
            ->assertJsonCount(3, 'data')
            ->assertJsonPath('meta.total', 3);
    }

    public function test_filtering_emails_by_recipient()
    {
        Mail::factory()->count(10)->create([
            'recipient' => 'recipientA@mail.com'
        ]);

        Mail::factory()->count(5)->create([
            'recipient' => 'recipientB@mail.com'
        ]);

        $this->getJson(route('mails.index', ['recipient' => 'recipientA@mail.com']))
            ->assertJsonCount(10, 'data')
            ->assertJsonPath('meta.total', 10);
    }

    public function test_filtering_emails_by_subject()
    {
        Mail::factory()->count(10)->create([
            'subject' => 'very important report'
        ]);

        Mail::factory()->count(5)->create([
            'subject' => null
        ]);

        Mail::factory()->count(5)->create([
            'subject' => 'important landing page'
        ]);

        $this->getJson(route('mails.index', ['subject' => 'report']))
            ->assertJsonCount(10, 'data')
            ->assertJsonPath('meta.total', 10);

        $this->getJson(route('mails.index', ['subject' => 'page']))
            ->assertJsonCount(5, 'data')
            ->assertJsonPath('meta.total', 5);

        $this->getJson(route('mails.index', ['subject' => 'important']))
            ->assertJsonCount(15, 'data')
            ->assertJsonPath('meta.total', 15);

        $this->getJson(route('mails.index', ['subject' => 'important landing']))
            ->assertJsonCount(5, 'data')
            ->assertJsonPath('meta.total', 5);
    }
}
