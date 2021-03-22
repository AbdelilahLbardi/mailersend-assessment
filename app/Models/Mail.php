<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Mail extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * @return HasMany
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class);
    }

    /**
     * @return HasMany
     */
    public function statuses(): HasMany
    {
        return $this->hasMany(Status::class)->orderByDesc('id');
    }

    /**
     * @return HasOne
     */
    public function status(): HasOne
    {
        return $this->hasOne(Status::class)->orderByDesc('id');
    }

    /**
     * @return $this
     */
    public function markAsPosted(): Mail
    {
        $this->statuses()->create([ 'status' => Status::POSTED ]);

        return $this;
    }

    /**
     * @return $this
     */
    public function markAsSent(): Mail
    {
        $this->statuses()->create([ 'status' => Status::SENT ]);

        return $this;
    }

    /**
     * @return $this
     */
    public function markAsFailed(): Mail
    {
        $this->statuses()->create([ 'status' => Status::FAILED ]);

        return $this;
    }
}
