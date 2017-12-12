<?php

namespace App\Repositories;

use App\Entities\User;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface UserRepository
 * @package namespace App\Repositories;
 */
interface UserRepository extends RepositoryInterface
{
    /**
     * @return Collection
     */
    public function getEnabledUsers(): Collection;

    /**
     * Проверяет существует ли в базе запись с данным VK ID.
     *
     * @param int $id
     * @return bool
     */
    public function checkVkAccount(int $id): bool;

    /**
     * @param int $id
     * @return null|User
     */
    public function findByTelegramId(int $id): ?User;
}
