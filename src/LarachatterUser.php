<?php

namespace Launcher/Larachatter;

use Illuminate\Database\Eloquent\Builder;

trait LarachatterUser
{
    public function scopeContacts(Builder $query): Builder
    {
        // E.g. filter contacts
        // return $query->where( 'your_logic_goes_here' );

        return $query;
    }
}
