<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'status',
        'number',
        'user_id'
    ];
    protected $appends = [
        'formatted_id'
    ];
    protected static function booted()
    {
        static::created(function ($document) {
            if(!$document->number){
                $document->number = $document->user->userDocuments->count();
                $document->save();
            }
        });
        static::deleted(function ($document) {
            $document->user->userDocuments->sortBy('id')->each(function ($item,$key){
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

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function pagesCount()
    {
        return $this->hasMany(Pages::class, 'document_id')->count();
    }
    public function pages()
    {
        return $this->hasMany(Pages::class, 'document_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
