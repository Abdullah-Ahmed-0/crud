@extends('layouts.app')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>Users</h1>
        <div class="lead">
            Manage your users here.
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm float-right">Add new user</a>
        </div>

        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col" width="1%">#</th>
                <th scope="col" width="15%">Name</th>
                <th scope="col">Email</th>
                <th scope="col" width="15%">Gender</th>
                <th scope="col" width="15%">status</th>
                <th scope="col" class="text-center" width="1%" colspan="3">Actions</th>
            </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <th scope="row">{{ $user['id'] }}</th>
                        <td>{{ $user['name'] }}</td>
                        <td>{{ $user['email'] }}</td>
                        <td>{{ $user['gender'] }}</td>
                        <td>{{ $user['status'] }}</td>
                        <td><a href="{{ route('users.show', $user['id']) }}" class="btn btn-warning btn-sm">Show</a></td>
                        <td><a href="{{ route('users.edit', $user['id']) }}" class="btn btn-info btn-sm">Edit</a></td>
                        <td>
                            <button type="button"  data-url="{{ route('users.delete', ['id' => $user['id']]) }}" class="btn btn-sm btn-danger"  data-bs-toggle="modal" data-bs-target="#confirmDelete" data-userid="{{ $user['id'] }}">Delete</button>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    <div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteLabel">Confirm Delete</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this user?
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="userId" id="userId">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('script')
    <script>
        $('#confirmDelete').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget)             // Button that triggered the modal
            let userId = button.data('userid')              // Extract user ID from data attribute
            let url = button.data('url');                   // Get the delete url
            let modal = $(this)
            modal.find('#userId').val(userId)               // Set value of userId input field
            modal.find('#deleteForm').attr('action', url);  // Set value of action attribute with the delete url
        })
    </script>
@endpush
