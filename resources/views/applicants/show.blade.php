@extends('layouts.admin.main')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 mt-5">
                <h1>{{ $listing->title }}</h1>
            </div>
            <div class="card mt-5">
                <div class="row g-0">
                    <div class="col-auto">

                        <img src="https://placehold.co/400" class="rounded-circle" style="width: 150px;" alt="Profile Picture">

                    </div>
                    <div class="col">
                        <div class="card-body">
                            @foreach ($listing->users as $user)
                                <p class="fw-bold"> {{ $user->name }} </p>
                                <p class="card-text">{{ $user->email }}</p>
                                <p class="card-text">Applied on</p>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-auto align-self-center">
                        <form action="#" method="post">
                            <a href="#" class="btn btn-primary" target="_blank">Download Resume</a>
                            <button type="submit" class="">
                                Shortlist
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
