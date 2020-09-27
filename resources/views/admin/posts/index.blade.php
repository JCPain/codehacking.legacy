@extends('layouts.admin')
@section('content')
    <h1>Posts</h1>
    @if(Session::has('msg-created'))
        <p class="bg-success">{{session('msg-created')}}</p>
    @elseif(Session::has('msg-updated'))
        <p class="bg-info">{{session('msg-updated')}}</p>
    @elseif(Session::has('msg-deleted'))
        <p class="bg-danger">{{session('msg-deleted')}}</p>
    @endif
    @if(count($posts) > 0)
    <table class="table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Photo</th>
                <th>Title</th>
                <th>Owner</th>
                <th>Category</th>
                <th>Post link</th>
                <th>Comments</th>
                <th>Created</th>
                <th>Updated</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>{{$post->id}}</td>
                    <td><img height="50" width="70" src="{{$post->photo ? $post->photo->file : $post->photoPlaceholder()}}" alt=""></td>
                    <td><a href="{{route('admin.posts.edit', $post->id)}}">{{$post->title}}</a></td>
                    <td>{{$post->user->name}}</td>
                    <td>{{$post->category ? $post->category->name : 'Uncategorized'}}</td>
                    <td><a href="{{route('home.post', $post->slug)}}">View Post</a></td>
                    <td><a href="{{route('admin.comments.show', $post->id)}}">View Comments</a></td>
                    <td>{{$post->created_at->diffForHumans()}}</td>
                    <td>{{$post->updated_at->diffForHumans()}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <h1 class="alert alert-danger text-center">No Posts</h1>
    @endif
    <div class="row">
        <div class="col-sm-6 col-sm-offset-5">
            {{$posts->render()}}
        </div>
    </div>
@stop