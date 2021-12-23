<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Restores extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'new_email',
        'link',
        'user_id',
        'active',
    ];

    public function getRouteKeyName()
    {
        return 'link';
    }
}
