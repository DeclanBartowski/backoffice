<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TariffsUserBlocks extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'tariff',
        'active_to',
    ];


    public function tariffElement()
    {
        return $this->belongsTo(Tariffs::class, 'tariff', 'id');
    }
}
