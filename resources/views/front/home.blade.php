@extends('layouts.blog-home')

@section('content')
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <!-- First Blog Post -->
            @if(count($posts) > 0)
                @foreach($posts as $post)
                <h2>
                    <a href="#">{{$post->title}}</a>
                </h2>
                <p class="lead">
                    by {{$post->user->name}}
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted {{$post->created_at->diffForHumans()}}</p>
                <hr>
                <img class="img-responsive" src="{{$post->photo_id ? $post->photo->file : $post->photoPlaceHolder()}}" alt="">
                <hr>
                <p>{!! str_limit($post->body, 100) !!}</p>
                <a class="btn btn-primary" href="post/{{$post->slug}}">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>
                @endforeach

                <!-- Pagination -->
                <div>
                    {{$posts->render()}}
                </div>
            @else
                <h1 class="alert alert-danger text-center">No Posts</h1>
            @endif

        </div>

        <!-- Blog Sidebar -->
        @include('includes.front_sidebar')

    </div>
    <!-- /.row -->
@endsection
