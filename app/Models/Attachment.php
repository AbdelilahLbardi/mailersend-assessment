<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attachment extends Model
{
    use HasFactory;

    protected $guarded = [];

    const MAX_FILE_SIZE = 5 * 1000;

    /**
     * @return BelongsTo
     */
    public function mail(): BelongsTo
    {
        return $this->belongsTo(Mail::class);
    }
}
