<x-mail::message>

    Congratulations, {{ $name }}!
    You have beem shortlisted for a job titled {{ $title }}. Please be ready for the interview.

    Best regards,<br>
    {{ config('app.name') }}
</x-mail::message>
