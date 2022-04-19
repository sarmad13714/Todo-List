@extends("layouts.app")
@section("content")
    <div class="container">
        @if(session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Done !!! </strong>{{ session()->get('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (count($errors) > 0)
            <div class = "alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="col-md-8 offset-2">
            
            <form method="POST" action={{url('/task')}}>
                {{csrf_field()}}
                <label for="">Description:</label>
                <div class="form-group">
                    <input type="text" class="form-control" name="name" placeholder="Enter Task Details">
                </div>
                <label for="">Deadline:</label>
                <div class="form-group">
                    <input type="date" class="form-control" name="date">
                </div>
                <div class="form-group">
                    <input type="time" class="form-control" name="time">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Add</button>
                </div>
            </form>

            <table id="taskTable">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td>{{ $task->name }} - Deadline:{{ $task->deadline }}</td>
                        <td><a class="btn btn-danger btn-sm" href ={{url('/'.$task->id.'/delete')}}>Delete</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
