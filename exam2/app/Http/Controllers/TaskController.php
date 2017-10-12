<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\TaskRepository;
use App\Task;

class TaskController extends Controller
{
    /**
     * The task repository instance.
     * @var TaskRepository
     */
    protected $tasks;

    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $tasks = $request->user()->tasks()->get();
        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:15',
        ]);
        // Create The Task...
        $request->user()->tasks()->create([
        'name' => $request->name,
        ]);
        return redirect('/tasks');
    }

    public function destroy(Task $task)
    {
        
        $this->authorize('destroy', $task);
        $task->delete();
        return redirect('/tasks');
    }
}
