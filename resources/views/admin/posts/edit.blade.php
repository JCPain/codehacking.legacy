@extends('layouts.admin')
@section('content')
    <h1>Edit Post</h1>
    @include('includes.tinyeditor')
    <div class="row">
        <div class="col-sm-3">
            <img class="img-responsive" src="{{$post->photo ? $post->photo->file : $post->photoPlaceholder()}}" alt="">
        </div>
        <div class="col-sm-9">
            {!! Form::model($post, ['method' => 'PATCH', 'action' => ['AdminPostsController@update', $post->id], 'files' => true]) !!}
                <div class="form-group">
                    {!! Form::label('title', 'Title:') !!}
                    {!! Form::text('title', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('category_id', 'Category:') !!}
                    {!! Form::select('category_id', ['' => 'Choose Categories'] + $categories, null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('photo_id', 'Photo:') !!}
                    {!! Form::file('photo_id', ['class' => 'form-control-file']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('body', 'Description:') !!}
                    {!! Form::textarea('body', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::submit('Update Post', ['class' => 'btn btn-info btn-block']) !!}
                </div>
            {!! Form:: close() !!}
            {!! Form::open(['method' => 'DELETE', 'action' => ['AdminPostsController@destroy', $post->id]]) !!}
                <div class="form-group">
                    {!! Form::submit('Delete Post', ['class' => 'btn btn-danger btn-block']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="row">
        @include('includes.form_error')
    </div>
@stop