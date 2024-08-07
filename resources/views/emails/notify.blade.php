<x-mail::message>
    # Introduction

    Congratulations! you are now a premium user
    <p>Your Purchase Details:</p>
    <p>Plan: {{ $plan }}</p>
    <p>Your Plan ends on: {{ $billingEnds }}</p>
    <x-mail::button :url="''">
        Post a Job
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
