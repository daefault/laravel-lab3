<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'friend_id',
        'status',
    ];

    /**
     * Получить пользователя, отправившего запрос
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Получить пользователя, получившего запрос
     */
    public function friend()
    {
        return $this->belongsTo(User::class, 'friend_id');
    }

    /**
     * Проверка, принята ли дружба
     */
    public function isAccepted()
    {
        return $this->status === 'accepted';
    }

    /**
     * Проверка, ожидает ли запрос
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }
}