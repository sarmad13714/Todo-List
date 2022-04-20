@extends("layouts.app")
@section("content")

    <style>
        .formContainer{
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 15px;
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
            <form method="POST" id="taskForm">
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
                        <button type="submit" class="btn btn-success addBtn">Add</button>
                    </div>

            </form>
        </div>


        <div class="tableContainer">
            <table id="taskTableAjax" class="table table-bordered data-table">
                <thead>
                <tr>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

    </div>

    <script>

        $(document).ready(function(){

            var table = $('#taskTableAjax').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('/') }}",
                columns: [
                    {data: 'description', name: 'description'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            $('#taskForm').on('submit', function(e){
                e.preventDefault();
                saveTask();
            });

            $(document).on('.deleteBtn','click', function(){
                let id = $(this).attr('data-val');
                deleteTask(id);
            });
        });

        function saveTask(){
            $('.addBtn').prop('disabled', true);
            $('.addBtn').text('Saving...');
            $.ajax({
                type:'POST',
                url:"{{url('/task')}}",
                data:{
                    _token: "{{ csrf_token() }}",
                    name: $('input[name=name]').val(),
                    date: $('input[name=date]').val(),
                    time: $('input[name=time]').val()
                },
                success: function( msg ) {
                    $('input[name=name]').val('');
                    $('input[name=date]').val('');
                    $('input[name=time]').val('');
                    $('#taskTableAjax').DataTable().ajax.reload();
                    alert('Task Added Successfully');
                    $('.addBtn').prop('disabled', false);
                    $('.addBtn').text('Add');
                }
            });
        }

        function deleteTask(id){
            $.ajax({
                type:'GET',
                url:"{{url('/')}}/"+id+'/delete',
                data:{
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function( msg ) {
                    $('#taskTableAjax').DataTable().ajax.reload();
                    alert('Task Deleted Successfully');
                }
            });
        }
    </script>

@endsection
