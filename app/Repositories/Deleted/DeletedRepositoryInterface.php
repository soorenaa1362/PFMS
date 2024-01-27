<?php

namespace App\Repositories\Deleted;

interface DeletedRepositoryInterface
{
    public function getUserId();

    public function getIncomes($userId);

    public function getCosts($userId);
}





