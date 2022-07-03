<?php

namespace App\Models;

use App\CPU\Helpers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use PHPUnit\TextUI\Help;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function translations()
    {
        return $this->morphMany('App\Models\Translation', 'translationable');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id')->orderBy('priority','desc');
    }

    public function childes()
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('priority','desc');
    }

    public function getNameAttribute($name)
    {
        if (strpos(url()->current(), '/admin') || strpos(url()->current(), '/seller')) {
            return $name;
        }

        return $this->translations[0]->value ?? $name;
    }
    public function scopePriority($query)
    {
        return $query->orderBy('priority','asc');
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('translate', function (Builder $builder) {
            $builder->with(['translations' => function ($query) {
                if (strpos(url()->current(), '/api')){
                    return $query->where('locale', App::getLocale());
                }else{
                    return $query->where('locale', Helpers::default_lang());
                }
            }]);
        });
    }
}
