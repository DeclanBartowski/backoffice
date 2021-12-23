<?php

namespace App\Models;

use App\Services\BlocksTypeService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class VariantBlocks extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'preview',
        'tariffs',
        'detail',
        'detail_actual',
        'status',
        'block_id',
        'number',
    ];

    const TARIFFS = [
        'draft' => 'Черновик',
        'public' => 'Опубликован',
    ];

    protected $casts = [
        'tariffs' => 'array'
    ];
    protected $appends = [
        'locked'
    ];


    public function getCreatedAtAttribute($value): string
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d.m.y H:i');
    }

    public function getUpdatedAtAttribute($value): string
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d.m.y H:i');
    }

    protected static function booted()
    {
        static::creating(function ($variantBlock) {
            if($variantBlock->status == 'public') {
                $variantBlock->detail_actual = $variantBlock->detail;
            }
            $variantBlock->number = (new BlocksTypeService())->getID($variantBlock->block_id);
        });

        static::updating(function ($variantBlock) {
            if($variantBlock->status == 'public') {
                $variantBlock->detail_actual = $variantBlock->detail;
            }
            $variantBlock->number = (new BlocksTypeService())->getID($variantBlock->block_id);
        });
    }

    public function getNumberAttribute($value): string
    {

        return str_pad($value, 3, "0", STR_PAD_LEFT);
    }
    public function getLockedAttribute()
    {

        $result = !isNull($this->tariffs);
        if(Auth::check()){
            $user = Auth::user();
            if($user->tariff && $this->tariffs){
                $result = !in_array($user->tariff->id,$this->tariffs);
            }

        }
        return $result;
    }
    public function block()
    {
        return $this->belongsTo(Blocks::class, 'block_id','id');
    }


}
