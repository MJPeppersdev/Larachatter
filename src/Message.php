<?php

namespace Launcher\Larachatter;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $table = 'larachatter_messages';

    protected $fillable = ['seen_at'];

    protected $casts = [
        'deleted_by_sender'         => 'boolean',
        'deleted_by_receiver'       => 'boolean',
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(config('larachatter.models.user'), 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(config('larachatter.models.user'), 'receiver_id');
    }
}
