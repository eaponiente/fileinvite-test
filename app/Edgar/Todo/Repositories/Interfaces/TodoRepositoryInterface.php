<?php

namespace App\Edgar\Todo\Repositories\Interfaces;

use App\Edgar\Base\BaseRepositoryInterface;
use App\Edgar\Todo\Todo;

interface TodoRepositoryInterface extends BaseRepositoryInterface
{
    public function createTodo(array $data) : Todo;

    public function updateTodo(array $update) : bool;

    public function findTodoById(string $id) : Todo;

    public function deleteTodo() : bool;

    public function listAllTodos();
}
