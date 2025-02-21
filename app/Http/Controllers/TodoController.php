<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Todo;
use Illuminate\Support\Facades\Log;
class TodoController extends Controller

{
    public function index(){
        //select all
            $todos = Todo::where('user_id' , auth()->id())->latest()->simplePaginate(5);
          //query to count all the todo tha user created where it completed
            $completedCount = Todo ::where('user_id' , auth()->id())->where('completed',true)->count();
         //select all todo either completed or not
            $todoCompleted = Todo::where('user_id',auth()->id())->count();
              // select all todo that in trash
            $trashedTodo =  Todo::onlyTrashed()->get()->count();
            // dd( $completedCount , $todoCompleted)

            return view('home' , compact( 'todos','completedCount' , 'todoCompleted' ,'trashedTodo'));
    }
     //store
    public function store(Request $request){
        Log::debug("print the request title ",  ['title'=>$request->title]);


        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255|',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $todos = Todo::create([
            'title'=>$request->title,
            'completed'=>false,
            'user_id'=>auth()->id(),
        ]);
        Log::debug("Todo created: ", $todos->toArray()); // Log the array

        return redirect('/todos');
    }
    //delete
    public function destroy(Todo $todo){
        $todo->delete();
        return redirect('/todos');
    }
    //update
    public function update(Todo $todo){

        request()->validate([
        'title'=>['required' ,'min:3'],
            'user_id'=>['require'],
        ]);
        $todo->update([
            'title'=>request('title'),
            'user_id'=>auth()->id(),
        ]);
        return redirect('/todos');
    }

    //trashed
    public function trashed(Todo $deletedTodos ){
        $deletedTodos = Todo::onlyTrashed()->get();
        return view('trashed' , ['deletedTodos'=>$deletedTodos ]);
    }

    //restore
    public function restore($id){
        $restore = Todo::withTrashed()->find($id);
        $restore->restore();
        return redirect('/todos');
    }

    //forceDelete
    public function forceDelete($id){
        $deletedTodo = Todo::withTrashed()->find($id); // Find the soft-deleted todo
        $deletedTodo->forceDelete(); // Permanently deletes the todo
        return redirect()->route('todos.trashed');
    }
    //completed
    public function toggleCompleted( Todo $todo ){
        $todo->completed = ! $todo->completed ;
        $todo->save();
        // dd($todo->completed);
    return redirect('/todos');
    }

    //clear all todos
    public function clearAll(){
        Todo::withoutTrashed()->delete();
        return redirect('/todos');
    }

    //clear trash
    public function clearTrash(){
        Todo::onlyTrashed()->forceDelete();
        return redirect()->route('todos.trashed');
    }
}
