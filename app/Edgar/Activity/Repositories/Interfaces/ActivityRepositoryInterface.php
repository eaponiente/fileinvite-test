<?php

namespace App\Edgar\Activity\Repositories\Interfaces;

use App\Edgar\Base\BaseRepositoryInterface;
use App\Edgar\Activity\Activity;

interface ActivityRepositoryInterface extends BaseRepositoryInterface
{
    public function createActivity(array $data) : Activity;

    public function updateActivity(array $update) : bool;

    public function findActivityById(string $id) : Activity;

    public function deleteActivity() : bool;

    public function listAllActivities();
}
