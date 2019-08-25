<?php

namespace Tests\Unit;

use App\Edgar\Todo\Exceptions\TodoNotFoundException;
use App\Edgar\Todo\Repositories\TodoRepository;
use App\Edgar\Todo\Todo;
use Tests\TestCase;

class TodoUnitTest extends TestCase
{
    /** @test */
    public function it_can_list_all_the_todos()
    {
        factory(Todo::class, 20)->create();

        $todoRepo = new TodoRepository(new Todo);
        $lists = collect($todoRepo->listAllTodos())->all();

        $this->assertCount(20, $lists);
    }

    /** @test */
    public function it_can_delete_the_todo()
    {
        $todo = factory(Todo::class)->create();

        $todoRepo = new TodoRepository($todo);
        $todoRepo->deleteTodo();

        $this->assertDatabaseMissing('todos', ['id' => $todo->id]);
    }

    /** @test */
    public function it_errors_when_the_todo_is_not_found()
    {
        $this->expectException(TodoNotFoundException::class);

        $todoRepo = new TodoRepository(new Todo);
        $todoRepo->findTodoById(999);
    }

    /**
     * @test
     * @throws TodoNotFoundException
     */
    public function it_can_show_the_todo()
    {
        $todo = factory(Todo::class)->create();

        $todoRepo = new TodoRepository(new Todo);
        $found = $todoRepo->findTodoById($todo->id);

        $this->assertEquals($todo->name, $found->name);
        $this->assertEquals($todo->email, $found->email);
    }

    /** @test */
    public function it_can_update_the_todo()
    {
        $todo = factory(Todo::class)->create();

        $update = [
            'name' => $this->faker->firstName
        ];

        $todoRepo = new TodoRepository($todo);
        $todoRepo->updateTodo($update);

        $this->assertEquals($update['name'], $todo->name);
    }

    /** @test */
    public function it_can_create_the_todo()
    {
        $data = [
            'name' => $this->faker->text,
        ];

        $todoRepo = new TodoRepository(new Todo);
        $todo = $todoRepo->createTodo($data);

        $this->assertEquals($data['name'], $todo->name);
    }
}