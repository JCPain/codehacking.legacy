@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.min.css">
@stop

@section('content')
    <h1>Upload Media</h1>
    {!! Form::open(['method' => 'POST', 'action' => 'AdminMediasController@store', 'class' => 'dropzone']) !!}
    {!! Form:: close() !!}
</div>
@stop

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.min.js"></script>
@stop