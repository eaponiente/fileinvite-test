<?php

namespace App\Edgar\Todo\Repositories;

use App\Edgar\Base\BaseRepository;
use App\Edgar\Todo\Exceptions\CreateTodoErrorException;
use App\Edgar\Todo\Exceptions\TodoNotFoundException;
use App\Edgar\Todo\Exceptions\UpdateTodoErrorException;
use App\Edgar\Todo\Repositories\Interfaces\TodoRepositoryInterface;
use App\Edgar\Todo\Todo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class TodoRepository extends BaseRepository implements TodoRepositoryInterface
{
    public function __construct(Todo $todo)
    {
        parent::__construct($todo);
        $this->model = $todo;
    }

    /**
     * Create the user
     *
     * @param array $data
     * @return Todo
     * @throws CreateTodoErrorException
     */
    public function createTodo(array $data) : Todo
    {
        try {
            $todo = new Todo($data);
            $todo->save();
            return $todo;
        } catch (QueryException $e) {
            throw new CreateTodoErrorException($e->getMessage());
        }
    }

    /**
     * Update the user details
     *
     * @param array $data
     * @return bool
     * @throws UpdateTodoErrorException
     */
    public function updateTodo(array $data) : bool
    {
        try {
            return $this->model->update($data);
        } catch (QueryException $e) {
            throw new UpdateTodoErrorException($e->getMessage());
        }
    }

    /**
     * Find todo by id
     *
     * @param string $id
     * @return Todo
     * @throws TodoNotFoundException
     */
    public function findTodoById(string $id) : Todo
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new TodoNotFoundException($e->getMessage());
        }
    }

    /**
     * Delete a todo
     *
     * @return bool
     */
    public function deleteTodo() : bool
    {
        return $this->model->delete();
    }

    /**
     * Return all the todos
     *
     * @param string $orderBy
     * @param string $sortBy
     * @param array $columns
     * @return Collection|mixed
     */
    public function listAllTodos(string $orderBy = 'created_at', string $sortBy = 'desc', array $columns = ['*'])
    : Collection {
        return $this->all($columns, $orderBy, $sortBy);
    }
}
