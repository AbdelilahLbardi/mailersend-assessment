<?php

namespace Database\Factories;

use App\Models\Mail;
use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

class StatusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Status::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'mail_id' => Mail::factory()->create()->id,
            'status' => array_rand(Status::getAllStatuses())
        ];
    }

    /**
     * @return Factory
     */
    public function posted(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => Status::POSTED,
            ];
        });
    }

    /**
     * @return Factory
     */
    public function sent(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => Status::SENT,
            ];
        });
    }

    /**
     * @return Factory
     */
    public function failed(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => Status::FAILED,
            ];
        });
    }
}
