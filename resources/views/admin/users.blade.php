@extends('admin.layouts.app')

@section('content')
    <div class="container">

        <h2>Users</h2>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Role</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td id="user_name_{{$user->id}}">{{ $user->name }}</td>
                        <td id="user_email_{{$user->id}}">{{ $user->email }}</td>
                        <td id="user_phone_{{$user->id}}">{{ $user->phone }}</td>
                        <td id="user_role_{{$user->id}}">{{ $user->role }}</td>
                        <td>
                            <a class="mr-2" href="#"><img id="edit_user" data-id="{{ $user->id }}" title="Edit" src="{{ asset('images/icons/edit.png') }}" /></a>
                            <a class="mr-2" href="{{ route('admin-user-delete', $user->id) }}"><img title="Delete" src="{{ asset('images/icons/cancel.png') }}" /></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if ($last_page > 1)
            <div style="text-align: center;">
                <ul style="list-style-type: none; display: inline-block;">
                    @foreach(range(1, $last_page) as $idx)
                        @if ($idx == $active_page)
                            <li style="float: left;" class="ml-2"><a href="javascript:void(0)" style="color: grey; pointer-events: none;">{{ $idx }}</a></li>
                        @else
                            <li style="float: left;" class="ml-2"><a href="{{ route('admin-users-list', $idx) }}">{{ $idx }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @endif

    </div>

    <form method="post" style=""></form>

    <div id="users_edit_dialog" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit user</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" type="text" id="user_id" />
                    <div class="form-group">
                        <label for="user_email" class="col-form-label">Email:</label>
                        <input type="text" disabled class="form-control" id="user_email">
                    </div>
                    <div class="form-group">
                        <label for="user_name" class="col-form-label">Name:</label>
                        <input type="text" class="form-control" id="user_name">
                    </div>
                    <div class="form-group">
                        <label for="user_phone" class="col-form-label">Phone:</label>
                        <input type="text" class="form-control" id="user_phone">
                    </div>
                    <div class="form-group">
                        <label for="user_role" class="col-form-label">Role:</label>
                        <select id="user_role" class="form-select" aria-label="Default select example">
                            <option value="regular">Regular</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="save_edited_user" type="button" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection