<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Job portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/filepond@^4/dist/filepond.css">
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

    <nav class="navbar navbar-expand-lg bg-dark shadow-lg" data-bs-theme="dark">
        <div class="container">
            <a class="navbar-brand" href="/">Tech Jobs</a>


            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Home</a>
                    </li>

                    @if (Auth::check())
                        <li class="nav-item dropdown">
                            <a class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                @if (auth()->user()->profile_pic)
                                    <img src="{{ Storage::url(auth()->user()->profile_pic ?? '') }}" width="40"
                                        class="rounded-circle">
                                @else
                                    <img src="https://placehold.co/400" class="rounded-circle" width="40">
                                @endif
                            </a>
                            <ul class="dropdown-menu">

                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page"
                                        href="{{ route('seeker.profile') }}">Profile</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{ route('job.applied') }}">Job
                                        Applied</a>
                                </li>
                                <li class="nav-item">
                                    <form id="form-logout" action="{{ route('logout') }}" method="get"> @csrf

                                        <a class="nav-link" id="form-logout" href="{{ route('logout') }}">Logout</a>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif


                    @if (!Auth::check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('create.seeker') }}">Job Seeker</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('create.employer') }}">Employer</a>
                        </li>
                    @endif

                </ul>
            </div>
        </div>
    </nav>
    @yield('content')


</body>

</html>
