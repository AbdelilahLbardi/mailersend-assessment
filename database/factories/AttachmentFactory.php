<?php

namespace Database\Factories;

use App\Models\Attachment;
use App\Models\Mail;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AttachmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Attachment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'mail_id' => Mail::factory()->create()->id,
            'name' => $this->generateFileName()
        ];
    }

    /**
     * @return string
     */
    private function generateFileName(): string
    {
        $randomFileName = Str::of($this->faker->text(10))->replace(' ', '_');
        $randomExtension = array_rand([ 'jpg', 'png', 'pdf', 'txt', 'php', 'zip', 'rar', 'exe' ]);

        return $randomFileName . '.' . $randomExtension;
    }
}
