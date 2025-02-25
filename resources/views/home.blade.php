@extends('layouts.app')

@section('content')
<style>
    .checkHover:hover{
        font-size: 150%;
        box-shadow: 10px;
    }
</style>
<section class="vh-100" >
    <div class="container py-5 h-100 w-50 ">

    <div class="row d-flex justify-content-center align-items-center " >
        <div class="col col-xl-10 ">
        <div class="card rounded-5 shadow ">

            <div class="card-body p-5">
                {{-- alert --}}
                <div id="alerts">
                    <div id="successAlert" class="alert alert-success d-none"></div>
                    <div id="errorAlert" class="alert alert-danger d-none"></div>
                </div>
                {{-- end alert  --}}
                <div class="d-flex justify-content-center mb-2">
                  <p> <span class="them fw-bold text-uppercase fs-1">  {{ date('l') }} , </span>   <span class="them fs-5"> {{ date('F j') }}th </span> </p>
                </div>

                {{-- form --}}
            <div class="d-flex justify-content-center align-items-center mb-4" >
                <div data-mdb-input-init class="form-outline flex-fill">
                   <!-- Form to add a new Todo-->
                    <form id="addTodoForm" method="POST"  action="/todos" >
                        @csrf
                <input type="text" id="todoTitle" name="title" required class="form-control form-control-lg" placeholder="What do you need to do today?" />
                <label class="form-label" for="todoTitle"></label>
                @error('title')
                <p class="text-danger"> * {{ $message }}</p>
                @enderror
                </div>
                <button type="submit" class="border-0 btn-lg ms-2 bg-light text-primary">
                    <h3> <i class="bi bi-plus-circle-fill them"></i></h3>
                </button>
            </form>
            </div>
            {{-- item list  --}}
            <div> <form action="{{ route('todos.clearall') }}" method="post">@csrf @method('DELETE') <button type="submit" class="border-0 bg-light text-secondary mb-2 " > clear all </button></form> </div>
            @forelse ($todos as $todo)

            <ul class="list-group list-group-horizontal rounded-2 border p-3 bg-light mb-3" id="todoList">
                <li
                    class="list-group-item d-flex align-items-center ps-0 pe-3 py-1 rounded border-0 bg-transparent todo-{{ $todo->id }}">
                    <form method="post" action="{{ route('todos.toggleCompleted' , $todo->id) }}">
                        @csrf @method('PATCH')
                        <button type="submit"class="border-0 bg-light"> @if($todo->completed === 1) <i class="bi bi-check-square-fill them"> @else<i class="bi bi-square"></i> @endif</i></button>
                    </form>
                </li>
                {{-- {{ $todo->completed?'text-decoration-line-through':''  }} --}}
                <li
                    class="list-group-item px-3 py-1 d-flex align-items-center flex-grow-1 rounded border-0 bg-transparent todo-{{ $todo->id }}">
                    <p  @class(['lead','fw-normal' ,'them' ,'mb-0' ,'text-decoration-line-through' => $todo->completed])>{{ $todo->title }}</p>
                </li>
                <li class="list-group-item ps-3 pe-0 py-1 rounded border-0 bg-transparent todo-{{ $todo->id }}">
                  <div class="d-flex flex-row justify-content-end mb-1">
                        <form action="/todos/{{$todo->id}}"  method="post" >
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-danger border-0 delete-todo bg-light " data-id="{{ $todo->id }}"> <i class="bi bi-trash mx-3 text-secondary"></i></button>
                        </form>
                            <button type="button" class="text-primary  border-0 bg-light" data-bs-toggle="modal" data-bs-target="#editTodoModal{{ $todo->id }}">
                     <i class="bi bi-pencil-square them"></i>
                    </button>
                        </div>
                </li>
                </ul>
              <!--  Modal -->
              <div class="modal fade" id="editTodoModal{{ $todo->id }}" tabindex="-1" aria-labelledby="editTodoModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <!-- #endregion -->
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editTodoModalLabel">Edit Todo</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="/todos/{{ $todo->id }}" id="editTodoForm">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" id="editTodoId" name="id" value="{{ $todo->id }}">
                            <input type="text"  id="editTodoTitle" name="title"class="form-control" required value="{{ $todo->title }}" placeholder="{{ $todo->title }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn them-bg text-light">Save changes</button>
                    </form>
                    </div>
                    </div>
                </div>
                </div>
                <!--end Modal -->
                @empty
                    <li
                    class="list-group-item px-3 py-1 d-flex align-items-center flex-grow-1 rounded border-0 bg-transparent">
                    <p class="lead fw-normal mb-0">there is no todo yet</p>
                    </li>
                    @endforelse
            </ul>
            <hr>
            <div class="row">
                <div class="col-3 d-inline">
                <a href="{{ route('todos.trashed') }}" class="text-secondary text-decoration-none"><i class="bi bi-trash"></i> trash : {{ $trashedTodo }}</a>
            </div>

               <div class="col-3 d-inline">
                <p class="text-secondary "> All : {{ $todoCompleted }}</p>
               </div>
               <div class="col-3 d-inline">
                <p class="text-secondary "> completed : {{ $completedCount}}</p>
               </div>
               </div>
               <div class="p-3">
                {{ $todos->links() }}
            </div>
            </div>
        </div>

        </div>
    </div>
    </div>
</section>
@endsection
