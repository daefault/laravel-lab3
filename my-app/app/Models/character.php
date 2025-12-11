<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str; 
class character extends Model
{
     use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'image', 
        'description',
        'type'
    ];
    protected $dates = ['deleted_at'];
    public function setNameAttribute($value)
    {
           $this->attributes['name'] = Str::ucfirst(trim($value));
    }

    public function getTypeAttribute($value)
    {
         return Str::title($value);
    }

    // Мутатор для описания - убирает лишние пробелы
    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = preg_replace('/\s+/', ' ', trim($value));
    }

    public function getImageAttribute($value)
    {
        if (!empty($value) && !str_starts_with($value, 'http') && !str_starts_with($value, '/')) {
            return '/' . $value;
        }
        return $value;
    }
}