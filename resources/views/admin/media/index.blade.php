@extends('layouts.admin')
@section('content')
    <h1>Media</h1>
    @if(Session::has('msg-created'))
        <p class="bg-success">{{session('msg-created')}}</p>
    @elseif(Session::has('msg-updated'))
        <p class="bg-info">{{session('msg-updated')}}</p>
    @elseif(Session::has('msg-deleted'))
        <p class="bg-danger">{{session('msg-deleted')}}</p>
    @endif
    <div class="row">
        <div class="">
            @if(count($photos) > 0)
                <form action="delete/media" method="post" class="form-inline">
                    {{csrf_field()}}
                    {{method_field('delete')}}
                    {{-- <select name="checkBoxArray" class="form-control">
                        <option value="">Delete</option>
                    </select> --}}
                    <div class="form-group">
                        <input type="submit" class="btn btn-sm btn-danger" name="delete_all" value="Delete">
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="options"></th>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Created Date</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($photos as $photo)
                                <tr>
                                    <td><input class="checkBoxes" type="checkbox" name="checkBoxArray[]" value="{{$photo->id}}"></td>
                                    <td>{{$photo->id}}</td>
                                    <td><img height="50" width="100" src="{{$photo->file}}" alt=""></td>
                                    <td>{{$photo->created_at ? $photo->created_at->diffForHumans() : 'no date'}}</td>
                                    {{-- <td>
                                        <input type="hidden" name="photo_id" value="{{$photo->id}}">
                                        <div class="form-group">
                                            <input type="submit" name="delete_single[{{$photo->id}}]" class="btn btn-danger" value="Delete">
                                        </div>
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
            @else
                <h1 class="alert alert-danger text-center">No Photos</h1>
            @endif
        </div>
    </div>
@stop
@section('scripts')
    <script>
        $(document).ready(function() {

            $('#options').click(function() {

                if(this.checked) {

                    $('.checkBoxes').each(function() {

                        this.checked = true;

                    });

                } else {

                    $('.checkBoxes').each(function() {

                        this.checked = false;

                    });

                }

            });

        });
    </script>
@stop