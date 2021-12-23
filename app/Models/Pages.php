<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'number',
        'document_id',
    ];
    protected $appends = [
        'formatted_id'
    ];
    protected static function booted()
    {
        static::created(function ($page) {
            if(!$page->number){
                $page->number = $page->document->pagesCount();
                $page->save();
            }
        });
        static::deleted(function ($page) {
            $page->document->pages->sortBy('id')->each(function ($item,$key){
                $item->number = $key+1;
                $item->save();
            });

        });
    }
    public function getFormattedIdAttribute(): string
    {
        return str_pad($this->id, 3, "0", STR_PAD_LEFT);
    }

    public function getCreatedAtAttribute($value): string
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d.m.y H:i');
    }

    public function getUpdatedAtAttribute($value): string
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d.m.y H:i');
    }
    public function savedPage()
    {
        return $this->hasMany(BlocksUser::class, 'page_id');
    }
    public function document()
    {
        return $this->belongsTo(Documents::class, 'document_id');
    }

}
