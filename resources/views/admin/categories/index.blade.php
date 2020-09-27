@extends('layouts.admin')
@section('content')
    <h1>Categories</h1>
    @if(Session::has('msg-created'))
        <p class="bg-success">{{session('msg-created')}}</p>
    @elseif(Session::has('msg-updated'))
        <p class="bg-info">{{session('msg-updated')}}</p>
    @elseif(Session::has('msg-deleted'))
        <p class="bg-danger">{{session('msg-deleted')}}</p>
    @endif
    <div class="row">
        <div class="col-sm-6">
            {!! Form::open(['method' => 'POST', 'action' => 'AdminCategoriesController@store']) !!}
                <div class="form-group">
                    {!! Form::label('name', 'Name:') !!}
                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::submit('Create Category', ['class' => 'btn btn-warning']) !!}
                </div>
            {!! Form:: close() !!}
        </div>
        <div class="col-sm-6">
            @if(count($categories) > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Created Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{$category->id}}</td>
                                <td><a href="{{route('admin.categories.edit', $category->id)}}">{{$category->name}}</a></td>
                                <td>{{$category->created_at ? $category->created_at->diffForHumans() : 'no date'}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <h4 class="alert alert-danger text-center">No Categories</h4>
            @endif
        </div>
    </div>
@stop