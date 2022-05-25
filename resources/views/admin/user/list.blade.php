@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <h1>Users</h1>
                <table class="table table-dark">
                    <thead>
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Active?</th>
                        <th scope="col">Role</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{$user->title}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->userDetails != null ? $user->userDetails->phone : ''}}</td>
                            <td>{{$user->active === 1 ? 'Yes' : 'No' }}</td>
                            <td>{{$user->role->title}}</td>
                            <td>
                                @if($user->active === 0)
                                    <form class="form" method="post"
                                          action="{{ route('users.activate', $user->id) }}">
                                        @method('PUT')
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{$user->id}}">
                                        <input type="submit" value="Activate" class="btn btn-primary">
                                    </form>
                                @else
                                    <form class="form" method="post"
                                          action="{{ route('users.deactivate', $user->id) }}">
                                        @method('PUT')
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{$user->id}}">
                                        <input type="submit" value="Deactivate" class="btn btn-danger">
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
