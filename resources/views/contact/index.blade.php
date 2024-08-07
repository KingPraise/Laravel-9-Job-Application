<h1>Lost of users</h1>

@foreach ($contacts as $contact)
    <p>{{ $contact->name }}</p>
@endforeach
