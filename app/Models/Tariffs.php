<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Tariffs extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'limit',
        'price',
        'default'
    ];

    protected $casts = [
        'limit' => 'array'
    ];

    public function getStatistic(){
        $variants = VariantBlocks::where('tariffs','like',sprintf('%%%s%%',$this->id))->get();
        return [
            'variants'=>$variants->count(),
            'blocks'=>$variants->pluck('block_id')->unique()->count(),
        ];
    }


}
