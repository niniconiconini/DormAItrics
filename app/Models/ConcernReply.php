<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'concern_id',
    'user_id',
    'message',
])]
class ConcernReply extends Model
{
    use SoftDeletes;

    /**
     * @return BelongsTo<Concern, $this>
     */
    public function concern(): BelongsTo
    {
        return $this->belongsTo(Concern::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
