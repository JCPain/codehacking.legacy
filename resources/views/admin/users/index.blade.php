@extends('layouts.admin')
@section('content')
    <h1>Users</h1>
    @if(Session::has('msg-created'))
        <p class="bg-success">{{session('msg-created')}}</p>
    @elseif(Session::has('msg-updated'))
        <p class="bg-info">{{session('msg-updated')}}</p>
    @elseif(Session::has('msg-deleted'))
        <p class="bg-danger">{{session('msg-deleted')}}</p>
    @endif
    <table class="table">
        <thead>
            <tr>
            <th>Id</th>
            <th>Photo</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Created</th>
            <th>Updated</th>
            </tr>
        </thead>
        <tbody>
            @if($users)
                @foreach($users as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td><img height="50" width="70" src="{{$user->photo ? $user->photo->file : 'https://source.unsplash.com/featured/?sky'}}" alt=""></td>
                        <td><a href="{{route('admin.users.edit', $user->id)}}">{{$user->name}}</a></td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->role ? $user->role->name : 'User has no role'}}</td>
                        <td>{{$user->is_active == 1 ? 'Active' : 'Not Active'}}</td>
                        <td>{{$user->created_at->diffForHumans()}}</td>
                        <td>{{$user->updated_at->diffForHumans()}}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@stop