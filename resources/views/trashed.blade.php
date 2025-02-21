
@extends('layouts.app')
@section('content')
<section class="vh-100   ">
    <div class="container py-5 h-100 w-50">
    <div class="row d-flex justify-content-center align-items-center ">
        <div class="col col-xl-10 ">
        <div class="card rounded-5 shadow ">
            <div class="card-body p-5">
                <div class="d-flex justify-content-center align-items-center mb-4" >
                   <h1 class="text-secondary"> <i class="bi bi-trash"></i> trash </h1>
                </div>
                <form method="post" action="{{ route('todos.cleartrash') }}">
                    @csrf @method('DELETE')
                <button type="submit" class="text-decoration-none text-secondary bg-light border-0 pb-4"> clear all</button>
            </form>
            @forelse ($deletedTodos as $deletedTodo)

            <ul class="list-group list-group-horizontal rounded-2 border p-3 bg-light mb-3">
            <li
                class="list-group-item d-flex align-items-center ps-0 pe-3 py-1 rounded border-0 bg-transparent">
            </li>
            <li
                class="list-group-item px-3 py-1 d-flex align-items-center flex-grow-1 rounded border-0 bg-transparent">
                <p class="lead fw-normal mb-0">{{ $deletedTodo->title }}</p>
            </li>
            <li class="list-group-item ps-3 pe-0 py-1 rounded border-0 bg-transparent">
                <div class="d-flex flex-row justify-content-end mb-1">

                    <button type="button" class="text-danger border-0 delete-todo bg-light" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $deletedTodo->id }}">
                        <i class="bi bi-x-lg mx-3 text-danger"></i>
                      </button>
                    <a href="{{ route('todos.restore' , ['id'=>$deletedTodo->id]) }}" class="text-primary  border-0 bg-light text-decoration-none" >
                        restore
                    </a>
                    </div>
            </li>
            </ul>
            <!-- Modal -->
<div class="modal fade" id="exampleModal{{ $deletedTodo->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">delete permanently</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            Are you sure you want to delete it permanently?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
          <form method="POST" action="{{ route('todos.forceDelete' , ['id'=>$deletedTodo->id]) }}">
          @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        </div>
      </div>
    </div>
  </div>
                @empty
                    <li
                    class="list-group-item px-3 py-1 d-flex align-items-center flex-grow-1 rounded border-0 bg-transparent">
                    <p class="lead fw-normal mb-0">there is no todo in the trash</p>
                    </li>
                    @endforelse
            </ul>
        </div>
        {{-- <div class="p-5">
            {{ $todos->links() }}
        </div> --}}
        </div>
    </div>
    </div>
</section>


@endsection
