@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between">
            <h4>Recommended Jobs</h4>

            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Salary
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('listing.index', ['sort' => 'salary_high_to_low']) }}">High to
                            low</a></li>
                    <li><a class="dropdown-item" href="{{ route('listing.index', ['sort' => 'salary_low_to_high']) }}">Low
                            to high</a></li>

                </ul>

                <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Date
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('listing.index', ['date' => 'Latest']) }}">Latest</a></li>
                    <li><a class="dropdown-item" href="{{ route('listing.index', ['date' => 'Oldest']) }}">Oldest</a></li>
                </ul>

                <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Job type
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item"
                            href="{{ route('listing.index', ['job_type' => 'Fulltime']) }}">Fulltime</a>
                    </li>
                    <li><a class="dropdown-item"
                            href="{{ route('listing.index', ['job_type' => 'Parttime']) }}">Parttime</a>
                    </li>
                    <li><a class="dropdown-item" href="{{ route('listing.index', ['job_type' => 'Casual']) }}">Casual</a>
                    </li>
                    <li><a class="dropdown-item"
                            href="{{ route('listing.index', ['job_type' => 'Contract']) }}">Contract</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row mt-2 g-1">
            @foreach ($jobs as $job)
                <div class="col-md-3">
                    <div class="card p-2 {{ $job->job_type }}">
                        <div class="text-right"> <small class="badge text-bg-info">{{ $job->job_type }}</small> </div>
                        <div class="text-center mt-2 p-3"> <img class="rounded-circle"
                                src="{{ asset('storage/profile/' . basename($job->profile->profile_pic)) }}"
                                width="100" /> <br>
                            <p>{{ asset('storage/profile/' . basename($job->profile->profile_pic)) }}</p>
                            <span class="d-bl>ock font-weight-bold">{{ $job->title }}</span>
                            <hr> <span>{{ $job->profile->name }}</span>
                            <div class="d-flex flex-row align-items-center justify-content-center">
                                <small class="ml-1">{{ $job->address }}</small>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <span>${{ number_format((float) $job->salary, 2) }}</span>
                                <a href="{{ route('job.show', [$job->slug]) }}"><button class="btn btn-dark">Apply
                                        Now</button> </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <style>
        .Fulltime {
            background: green;
            color: #fff;
        }

        .Parttime {
            background: blue;
            color: #fff;
        }

        .Casual {
            background: red;
            color: #fff;
        }

        .Contract {
            background: purple;
            color: #fff;
        }
    </style>
@endsection
