<?php

namespace App\Http\Controllers\Api;

use App\Edgar\Activity\Repositories\Interfaces\ActivityRepositoryInterface;
use App\Edgar\Todo\Repositories\Interfaces\TodoRepositoryInterface;
use App\Edgar\Todo\Repositories\TodoRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TodoApiController extends Controller
{
    private $todoRepo;

    private $activityRepo;

    public function __construct(TodoRepositoryInterface $todoRepo,
                                ActivityRepositoryInterface $activityRepo)
    {
        $this->todoRepo = $todoRepo;

        $this->activityRepo = $activityRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = $this->todoRepo->listAllTodos();

        return response()->json($todos, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $todo = $this->todoRepo->createTodo($request->all());

        $this->activityRepo->createActivity(['description' => 'Todo ' . $todo->id . ' was created']);

        return response()->json($todo, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $todo = $this->todoRepo->findTodoById($id);

        return response()->json($todo, 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Edgar\Todo\Exceptions\UpdateTodoErrorException
     */
    public function update(Request $request, $id)
    {
        $todo = $this->todoRepo->findTodoById($id);

        $todoRepo = new TodoRepository($todo);

        $todoRepo->updateTodo($request->all());

        $this->activityRepo->createActivity(['description' => 'Todo ' . $todo->id . ' was updated']);

        return response()->json($todo, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $todo = $this->todoRepo->findTodoById($id);

        $todoRepo = new TodoRepository($todo);

        $todoRepo->deleteTodo();

        $this->activityRepo->createActivity(['description' => 'Todo ' . $todo->id . ' was deleted']);

        return response()->json($todo, 201);
    }
}
