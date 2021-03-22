<?php

namespace Database\Seeders;

use App\Models\Mail;
use App\Models\Status;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Mail::factory()->count(100)->create()->each(function (Mail $mail) {

            $randomStatus = array_rand([
                Status::POSTED => '1',
                Status::SENT => '2',
                Status::FAILED => '3',
            ]);

            if ($randomStatus == Status::SENT) {
                $mail->update([
                    'sent_at' => now()
                ]);
            }

            $mail->statuses()->create([
                'status' =>  $randomStatus
            ]);

        });
    }
}
