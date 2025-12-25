<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
class Character extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'image',
        'description',
        'type',
        'user_id'
    ];
    protected $dates = ['deleted_at'];
    protected static function boot()
    {
        parent::boot();

        // Closure для проверки перед обновлением (updating)
        static::updating(function ($character) {
            if (!Auth::check()) {
                throw new \Illuminate\Auth\Access\AuthorizationException(
                    'Требуется авторизация'
                );
            }

            $user = Auth::user();

            if ($character->user_id !== $user->id && !$user->is_admin) {
                throw new \Illuminate\Auth\Access\AuthorizationException(
                    'У вас нет прав на редактирование этого персонажа'
                );
            }

            return true;
        });

        // Closure для проверки перед удалением (deleting)
        static::deleting(function ($character) {
            if (!Auth::check()) {
                throw new \Illuminate\Auth\Access\AuthorizationException(
                    'Требуется авторизация'
                );
            }

            $user = Auth::user();

            if ($character->user_id !== $user->id && !$user->is_admin) {
                throw new \Illuminate\Auth\Access\AuthorizationException(
                    'У вас нет прав на удаление этого персонажа'
                );
            }

            return true;
        });

        // Closure для проверки перед восстановлением (restoring)
        static::restoring(function ($character) {
            if (!Auth::check()) {
                throw new \Illuminate\Auth\Access\AuthorizationException(
                    'Требуется авторизация'
                );
            }

            $user = Auth::user();

            if (!$user->is_admin) {
                throw new \Illuminate\Auth\Access\AuthorizationException(
                    'Только администратор может восстанавливать персонажей'
                );
            }

            return true;
        });
    }
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function commentsCount()
    {
        return $this->hasMany(Comment::class)->count();
    }
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