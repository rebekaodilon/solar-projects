<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Customer extends Model
{
    protected $table = 'customer';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'document'
    ];

    public function project()
    {
        return $this->hasMany(Project::class);
    }
}