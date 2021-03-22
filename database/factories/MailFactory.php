<?php

namespace Database\Factories;

use App\Models\Mail;
use Illuminate\Database\Eloquent\Factories\Factory;

class MailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Mail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sender' => $this->faker->unique()->safeEmail,
            'recipient' => $this->faker->unique()->safeEmail,
            'subject' => $this->faker->text(25),
            'text_content' => $this->faker->realText(50),
            'html_content' => $this->faker->randomHtml(),
        ];
    }

    /**
     * Indicates if the email does not have a text content.
     *
     * @return Factory
     */
    public function withoutTextContent(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'text_content' => null,
            ];
        });
    }

    /**
     * Indicates if the email does not have a html content.
     *
     * @return Factory
     */
    public function withoutHtmlContent(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'html_content' => null,
            ];
        });
    }

    /**
     * Indicates if the email does not have a subject.
     *
     * @return Factory
     */
    public function withoutSubject(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'subject' => null,
            ];
        });
    }
}
