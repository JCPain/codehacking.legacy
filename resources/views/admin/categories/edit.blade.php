@extends('layouts.admin')
@section('content')
    <h1>Categories</h1>
    <div class="row">
        <div class="col-sm-8">
            {!! Form::model($category, ['method' => 'PATCH', 'action' => ['AdminCategoriesController@update', $category->id]]) !!}
                <div class="form-group">
                    {!! Form::label('name', 'Name:') !!}
                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::submit('Update Category', ['class' => 'btn btn-warning btn-block']) !!}
                </div>
            {!! Form:: close() !!}
            {!! Form::open(['method' => 'DELETE', 'action' => ['AdminCategoriesController@destroy', $category->id]]) !!}
                <div class="form-group">
                    {!! Form::submit('Delete Category', ['class' => 'btn btn-danger btn-block']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop