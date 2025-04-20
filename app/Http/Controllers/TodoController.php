<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        // Retrieve all todos
        $todos = Todo::all();

        // Return the view with todos
        return view('main', compact('todos'));
    }

    public function store(Request $request)
    {
        Todo::create([
            'title' => $request->title,
            'datetime' => $request->datetime,
            'priority' => $request->priority,
            'pinned' => $request->pinned ? true : false,
        ]);

        return redirect()->back();
    }

    public function toggleComplete($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->completed = !$todo->completed;
        $todo->save();

        return back();
    }

    public function destroy($id)
    {
        Todo::destroy($id);
        return back();
    }

    public function update(Request $request, $id)
    {
        $todo = Todo::findOrFail($id);
        $todo->update([
            'title' => $request->title,
            'datetime' => $request->datetime,
        ]);

        return redirect()->back();
    }
}
