<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * App\User
 */
class User extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'telegram_id',
        'vk_id',
        'access_token',
        'last_date',
        'is_enabled'
    ];

    /**
     * @param int $postTime
     * @return bool
     */
    public function updateSeenDate(int $postTime): bool
    {
        return $this->update([
            'last_date' => ++$postTime
        ]);
    }

    /**
     * @return bool
     */
    public function enable(): bool
    {
        return $this->update([
            'is_enabled' => true,
            'last_date' => time()
        ]);
    }

    /**
     * @return bool
     */
    public function disable(): bool
    {
        return $this->update([
            'is_enabled' => false
        ]);
    }
}
