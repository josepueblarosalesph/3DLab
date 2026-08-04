<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'organization', 'role', 'area', 'email', 'message', 'read_at'])]
class Inquiry extends Model
{
    protected function casts(): array
    {
        return ['read_at' => 'datetime'];
    }
}
