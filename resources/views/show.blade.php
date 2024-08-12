@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <img src="{{ Storage::url($listing->feature_image) }}" class="card-img-top" alt="Cover Image"
                        style="height: 150px; object-fit: cover;">
                    <div class="card-body">
                        <h2 class="card-title">{{ $listing->title }}</h2>
                        <span class="badge bg-primary">{{ $listing->job_type }}</span>
                        <p>Salary: ${{ number_format((float) $listing->salary, 2) }} </p>
                        <p>Address: {{ $listing->address }}</p>
                        <h4 class="mt-4">Description</h4>
                        <p class="card-text">{!! $listing->description !!}
                        </p>

                        <h4>Roles and Responsibilities</h4>
                        {!! $listing->roles !!}

                        <p class="card-text mt-4">Application closing date: {{ $listing->application_close_date }}</p>
                        @if ($listing->profile->resume)
                            <a href="#" class="btn btn-primary mt-3">Apply Now</a>
                        @else
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop">
                                Apply
                            </button>
                        @endif
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <form action="{{ route('application.submit', [$listing->id]) }}" method="post">@csrf

                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Upload Resume</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="file" name="" id="">
                                        </div>
                                        <div class="modal-footer">

                                            <button type="submit" class="btn btn-primary" id="btnApply"
                                                disabled>Apply</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const inputElement = document.querySelector('input[type="file"]');
        const pond = FilePond.create(inputElement);
        pond.setOptions({
            server: {
                url: '/resume/upload',
                process: {
                    method: 'POST',
                    withCredentials: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    ondata: (formData) => {
                        formData.append('file', pond.getFiles()[0].file, pond.getFiles()[0].file.name)

                        return formData
                    },
                    onload: (response) => {
                        document.getElementById('btnApply').removeAttribute('disabled')
                    },
                    onerror: (response) => {
                        console.log('error while uploading....', response)
                    },
                },
            },
        });
    </script>
@endsection
