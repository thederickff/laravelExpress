@extends('app')


@section('content')

    <div class="row">
        <div class="col-md-12">
            <h1>Simple Laravel Ajax Crud</h1>
        </div>
    </div>


    <div class="form-group row add">
        <div class="col-md-5">
            <input type="text" class="form-control" id="title" name="title"
                   placeholder="Your title Here" required>

            <p class="error text-center alert alert-danger hidden"></p>

        </div>


        <div class="col-md-5">
            <input type="text" class="form-control" id="description" name="description"
                   placeholder="Your description Here" required>

            <p class="error text-center alert alert-danger hidden"></p>

        </div>

        <div class="col-md-2">
            <button class="btn btn-warning" type="submit" id="add">
                <span class="glyphicon glyphicon-plus"></span>Add new data
            </button>
        </div>
    </div>

    <div class="row">
        <div class="table-responsive">
            <table class="table table-borderless" id="table">
                <tr>
                    <th>No.</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
                {{ csrf_field() }}

                @foreach($blogs as $blog)
                    <tr id="item" class="item{{$blog->id}}">

                        <td id="id">{{$blog->id}}</td>
                        <td>{{$blog->title}}</td>
                        <td>{{$blog->description}}</td>
                        <td>
                            <button class="edit-modal btn btn-info"
                                    data-id="{{$blog->id}}" data-title="{{$blog->title}}"
                                    data-description="{{$blog->description}}">
                                <span class="glyphicon glyphicon-edit"></span> Edit
                            </button>

                            <button class="delete-modal btn btn-danger"
                                    data-id="{{$blog->id}}" data-title="{{$blog->title}}"
                                    data-description="{{$blog->description}}">
                                <span class="glyphicon glyphicon-trash"></span> Delete
                            </button>
                        </td>

                    </tr>
                @endforeach
            </table>
        </div>
    </div>


    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" id="closeModal" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label for="id" class="control-label col-sm-2">ID:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="fid" disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="title" class="control-label col-sm-2">Title:</label>
                            <div class="col-sm-10">
                                <input type="name" class="form-control" id="t">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="control-label col-sm-2">Description:</label>
                            <div class="col-sm-10">
                                <input type="name" class="form-control" id="d">
                            </div>
                        </div>
                    </form>

                </div>
                <div class="deleteContent text-center h4">
                    Are you sure you want to delete <mark class="title b"></mark> ?
                    <span class="hidden id"></span>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn actionBtn" data-dismiss="modal">
                        <span id="footer_action_button" class="glyphicon"> </span>
                        <span id="afterSpan"></span>
                    </button>
                    <button type="button" class="btn btn-warning" id="closeModal">
                        <span class="glyphicon glyphicon-remove"> </span> Close
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('script')
    <script>


        $(document).on('click','#closeModal', function(){
            $('#myModal').removeClass('in').hide();
        });
        function table(id, title, description) {


            return "<tr id='item' class='item" + id + "'><td id='id'>" + id + "</td><td>" + title + "</td><td>" + description + "</td><td><button class='edit-modal btn btn-info' data-id='" + id + "' data-title='" + title + "' data-description='" + description + "'><span class='glyphicon glyphicon-edit' ></span> Edit</button> <button class='delete-modal btn btn-danger' data-id='" + id + "' data-title='" + title + "' data-description='" + description + "'><span class='glyphicon glyphicon-trash'></span> Delete</button></td></tr>";
        }
        // Edit Data (Modal and function edit data)
        $(document).on('click', '.edit-modal', function () {
            $('#footer_action_button').addClass('glyphicon-check').removeClass('glyphicon-trash');
            $('#afterSpan').text('Update');
            $('.actionBtn').addClass('btn-sucess').removeClass('btn-danger').removeClass('delete').addClass('edit');
            $('.modal-title').text('Edit');
            $('.deleteContent').hide();
            $('.form-horizontal').show();
            $('#fid').val($(this).data('id'));
            $('#t').val($(this).data('title'));
            $('#d').val($(this).data('description'));

            $('#myModal').addClass('in').show();
        });
        $('.modal-footer').on('click', '.edit', function () {

            $('#myModal').removeClass('in').hide();
            $.ajax({
                type: 'post',
                url: '/editItem',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'id': $('#fid').val(),
                    'title': $('#t').val(),
                    'description': $('#d').val()
                },
                success: function (data) {
                    var id = data.id;
                    var title = data.title;
                    var description = data.description;

                    $('.item' + id).replaceWith(table(id,title, description));
                }
            });
        });

        // Add data function
        $('#add').on('click', function(){

            $.ajax({
                type: 'post',
                url: '/addItem',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'title': $('input[name=title]').val(),
                    'description': $('input[name=description]').val()
                },
                success: function(data){
                    if((data.errors)) {
                        $('.error').removeClass('hidden');
                        $('.error').text(data.errors.title);
                        $('.error').text(data.errors.description);
                    } else {
                        $('.error').remove();

                        var id = data.id;
                        var title = data.title;
                        var description = data.description;

                        $('#table').append(table(id, title, description));
                    }
                }

            });
            $('#title').val('');
            $('#description').val('');
        });
        // Delete Function
        $(document).on('click', '.delete-modal', function(){
            $('#footer_action_button').removeClass('glyphicon-check').addClass('glyphicon-trash');
            $('#afterSpan').text('Delete');
            $('.actionBtn').removeClass('btn-sucess').removeClass('edit').addClass('btn-danger').addClass('delete');
            $('.modal-title').text('Delete');
            $('#fid').val($(this).data('id'));
            $('.deleteContent').show();
            $('.form-horizontal').hide();
            $('.title').html($(this).data('title'));
            $('#myModal').addClass('in').show();
        });
        $('.modal-footer').on('click', '.delete', function(){
            $('#myModal').removeClass('in').hide();
            $.ajax({
                type: 'post',
                url: '/deleteItem',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'id': $('#fid').val()
                },
                success: function(data){
                    $('.item'+ $('#fid').val()).remove();
                }

            });
        });

        // Reload items

        $(document).on('click', '#title', function(){

            $('tr#item').each(function(i){

                $('.item'+$(this).find('td#id').text()).remove();
            });
            $.ajax({
                type: 'get',
                url: '/getItem',
                success: function(data){

                   $(data).each(function(i, c){
                       var index = i+1;

                       $('#table').append(table(c.id, c.title, c.description));
                   });
                }

            });
        });
    </script>
@endsection