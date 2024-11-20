<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Customer extends Model
{
    protected $fillable = [
        'foreign_id',
        'first_name',
        'last_name',
        'email',
        'foreign_created_at',
        'foreign_updated_at'
    ];

    protected $appends = [
        'name'
    ];

    protected function casts(): array
    {
        return [
            'foreign_created_at' => 'datetime',
            'foreign_updated_at' => 'datetime',
            'updated_at' => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn () => trim("$this->first_name $this->last_name")
        );
    }
}
