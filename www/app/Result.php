<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    //

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function term()
    {
        return $this->belongsTo(Term::class);
    }
}
