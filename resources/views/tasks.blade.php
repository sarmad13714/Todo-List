@extends("layouts.app")
@section("content")

    <style>
        .formContainer{
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 15px;
        }

        .tableContainer{
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 10px;
        }
    </style>

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

        <div class="formContainer">
            <form method="POST" action={{url('/task')}}>
                {{csrf_field()}}
                    <div class="row">
                        <div class="col-md-7">
                            <label for="">Description:</label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" placeholder="Enter Task Details" required>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <label for="">Deadline:</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="date" class="form-control" name="date" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="time" class="form-control" name="time" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Add</button>
                    </div>

            </form>
        </div>


        <div class="tableContainer">
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
                        <td>{{ $task->name }} - <span style="font-style: italic; font-weight: 500">Deadline: {{ date('g:i A, dS F, Y', strtotime($task->deadline)) }}</span></td>
                        <td><a class="btn btn-danger btn-sm" href ={{url('/'.$task->id.'/delete')}}>Delete</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection
