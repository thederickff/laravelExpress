@extends('template')


@section('content')
    <h1>Blog Admin</h1>


    <a href="{{route('admin.posts.create')}}" class="btn btn-success">Create new Post</a>
    <br><br/>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
            <tr>
                <td>{{$post->id}}</td>
                <td>{{$post->title}}</td>
                <td>
                    <a href="{{route('admin.posts.edit', ['id' => $post->id])}}" class="btn btn-default">Edit</a>
                    <a href="{{route('admin.posts.destroy', ['id' => $post->id])}}" class="btn btn-danger">Destroy</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    {!!$posts->render()!!}

@stop