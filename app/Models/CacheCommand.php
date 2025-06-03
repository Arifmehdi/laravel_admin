<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CacheCommand extends Model
{
    protected $fillable = [
        'name',
        'command',
        'city',
        'state',
        'description',
        'cache_file',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function getZipCodesArrayAttribute()
    {
        return array_map('trim', explode(',', $this->zip_codes));
    }
}
