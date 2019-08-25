<?php

namespace App\Edgar\Activity\Repositories;

use App\Edgar\Base\BaseRepository;
use App\Edgar\Activity\Exceptions\CreateActivityErrorException;
use App\Edgar\Activity\Exceptions\ActivityNotFoundException;
use App\Edgar\Activity\Exceptions\UpdateActivityErrorException;
use App\Edgar\Activity\Repositories\Interfaces\ActivityRepositoryInterface;
use App\Edgar\Activity\Activity;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class ActivityRepository extends BaseRepository implements ActivityRepositoryInterface
{
    public function __construct(Activity $activity)
    {
        parent::__construct($activity);
        $this->model = $activity;
    }

    /**
     * Create the user
     *
     * @param array $data
     * @return Activity
     * @throws CreateActivityErrorException
     */
    public function createActivity(array $data) : Activity
    {
        try {
            $activity = new Activity($data);
            $activity->save();
            return $activity;
        } catch (QueryException $e) {
            throw new CreateActivityErrorException($e->getMessage());
        }
    }

    /**
     * Update the user details
     *
     * @param array $data
     * @return bool
     * @throws UpdateActivityErrorException
     */
    public function updateActivity(array $data) : bool
    {
        try {
            return $this->model->update($data);
        } catch (QueryException $e) {
            throw new UpdateActivityErrorException($e->getMessage());
        }
    }

    /**
     * Find activity by id
     *
     * @param string $id
     * @return Activity
     * @throws ActivityNotFoundException
     */
    public function findActivityById(string $id) : Activity
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new ActivityNotFoundException($e->getMessage());
        }
    }

    /**
     * Delete activity
     *
     * @return bool
     * @throws \Exception
     */
    public function deleteActivity() : bool
    {
        return $this->model->delete();
    }

    /**
     * Return all the activities
     *
     * @param string $orderBy
     * @param string $sortBy
     * @param array $columns
     * @return Collection|mixed
     */
    public function listAllActivities(string $orderBy = 'created_at', string $sortBy = 'desc', array $columns = ['*'])
    : Collection {
        return $this->all($columns, $orderBy, $sortBy);
    }
}
