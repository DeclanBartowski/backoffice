<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Blocks extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'rules',
    ];
    protected $appends = [
      'formatted_id'
    ];

    const RULES = [
        'without_restriction' => 'Размещение вариантов блока в документе без ограничений',
        'document_only_one' => 'В документе может быть только один вариант этого блока',
        'page_only_one' => 'На странице может быть только один вариант этого блока',
    ];

    public function getCreatedAtAttribute($value): string
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d.m.y H:i');
    }

    public function getUpdatedAtAttribute($value): string
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d.m.y H:i');
    }

    /*public function getIDAttribute($value): string
    {
      return str_pad($value, 3, "0", STR_PAD_LEFT);
    }*/
    public function getFormattedIdAttribute(): string
    {
        return str_pad($this->id, 3, "0", STR_PAD_LEFT);
    }

    public function variantsCount()
    {
        return $this->hasMany(VariantBlocks::class, 'block_id')->count();
    }
    public function variants()
    {
        return $this->hasMany(VariantBlocks::class, 'block_id','id');
    }



}
