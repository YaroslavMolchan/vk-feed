<?php

namespace App\Repositories;

use App\Entities\User;
use App\Validators\UserValidator;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class UserRepositoryEloquent
 * @package namespace App\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * @return Collection
     */
    public function getEnabledUsers(): Collection
    {
        $query = $this->model->newQuery();

        $query->where('is_enabled', true);

        return $query->get();
    }

    /**
     * Проверяет существует ли в базе запись с данным VK ID.
     *
     * @param int $id
     * @return bool
     */
    public function checkVkAccount(int $id): bool
    {
        $query = $this->model->newQuery();
        
        $query->where('vk_id', $id);
        
        return $query->exists();
    }

    /**
     * @param int $id
     * @return null|User
     */
    public function findByTelegramId(int $id): ?User
    {
        $query = $this->model->newQuery();

        $query->where('telegram_id', $id);

        return $query->first();
    }
}
