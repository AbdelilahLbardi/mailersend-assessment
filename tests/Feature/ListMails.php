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
}
