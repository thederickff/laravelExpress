@extends('template')


@section('content')


    <h1>Create new Post</h1>

    @if($errors->any())
        <ul class="list-unstyled alert-warning">
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif
    {!!Form::open(['route' => 'admin.posts.store','method' => 'post'])!!}

    <!-- Text Input-->
    <div class="form-group">

        {!! Form::label('title', 'Title:')!!}
        {!! Form::text('title', null, ['class' => 'form-control'])!!}

    </div>
    <div class="form-group">

        {!! Form::label('content', 'Content:')!!}
        {!! Form::textarea('content', null, ['class' => 'form-control'])!!}

    </div>
    <div class="form-group">


        {!! Form::submit('Create Post', ['class' => 'btn btn-primary'])!!}

    </div>
    {!!Form::close() !!}
@stop
