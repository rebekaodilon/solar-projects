<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Customer extends Model
{
    protected $table = 'customers';

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}