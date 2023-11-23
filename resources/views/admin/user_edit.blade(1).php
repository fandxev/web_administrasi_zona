<!-- resources/views/admin/user_edit.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Edit User
                    </div>

                    <div class="card-body">
                        <form action="{{ route('user.update', $user->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>

                        <!-- Delete form -->
                        <form action="{{ route('user.destroy', $user->id) }}" method="post" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
