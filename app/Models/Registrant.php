<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registrant extends Model
{
    public function programme()
    {
        return $this->belongsTo(Programme::class);
    }
}
