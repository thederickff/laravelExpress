@extends('template')


@section('content')


    <h1>Edit Post {{$post->title}}</h1>

    @if($errors->any())
        <ul class="list-unstyled alert-warning">
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif
    {!! Form::model($post, ['route' => ['admin.posts.update', $post->id],'method' => 'put'])!!}

        @include('admin.post._form')

    <div class="form-group">

        {!! Form::submit('Save', ['class' => 'btn btn-primary'])!!}

    </div>
    {!!Form::close() !!}
@stop
