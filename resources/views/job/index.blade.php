@extends('layouts.admin.main')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <h1>Your Jobs</h1>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Your Jobs
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Created On</th>
                                <th>Edit</th>
                                <th>Delete</th>

                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Title</th>
                                <th>Created</th>
                                <th>Edit</th>
                                <th>Deleted</th>

                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($jobs as $job)
                                <tr>
                                    <td>{{ $job->title }}</td>
                                    <td>{{ $job->created_at->format('Y-m-d') }}</td>
                                    <td><a href="{{ route('job.edit', $job->id) }}">Edit</a></td>
                                    <td><a href="#" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal{{ $job->id }}">Delete</a>
                                    </td>
                                </tr>
                                <!-- Modal -->

                                <div class="modal fade" id="exampleModal{{ $job->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <form action="{{ route('job.delete', [$job->id]) }}" method="post"> @csrf
                                        @method('DELETE')
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Confirmation
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this job?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger">Save changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            @if (Session::has('success'))
                <div calass="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif
            <form action="{{ route('user.update.profile') }}" method="post" enctype="multipart/form-data">@csrf
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="logo">Logo</label>
                        <input type="file" class="form-control" id="logo" name="profile_pic">
                        @if (auth()->user()->profile_pic)
                            <img src="{{ Storage::url(auth()->user()->profile_pic) }}" width="150" class="mt-3">
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="name">Company name</label>
                        <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}">
                    </div>
                    <div class="form-group mt-4">
                        <button class="btn btn-success" type="submit">Update</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="row justify-content-center">
            <h2>Change your password</h2>

            <form action="#" method="post">@csrf
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="current_password">Your current password</label>
                        <input type="password" name="current_password" class="form-control" id="current_password">
                    </div>
                    <div class="form-group">
                        <label for="password">Your new password</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm password</label>
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                    </div>
                    <div class="form-group mt-4">
                        <button class="btn btn-success" type="submit">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
