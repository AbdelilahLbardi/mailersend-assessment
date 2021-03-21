<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Status extends Model
{
    use HasFactory;

    protected $guarded = [];

    const POSTED = 1;
    const SENT = 2;
    const FAILED = 3;


    /**
     * @return BelongsTo
     */
    public function mail(): BelongsTo
    {
        return $this->belongsTo(Mail::class);
    }

    /**
     * @return bool
     */
    public function posted(): bool
    {
        return $this->attributes['status'] === self::POSTED;
    }

    /**
     * @return bool
     */
    public function sent(): bool
    {
        return $this->attributes['status'] === self::SENT;
    }

    /**
     * @return bool
     */
    public function failed(): bool
    {
        return $this->attributes['status'] === self::FAILED;
    }

    /**
     * @return int[]
     */
    public static function getAllStatuses(): array
    {
        return [ self::POSTED, self::SENT, self::FAILED ];
    }
}
