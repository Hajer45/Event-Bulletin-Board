<x-mail::message>
    # Event Updated

    Hello {{ $event->user->name }},

    Your event **{{ $event->title }}** has been updated.

    ## Updated Event Details

    - **Title:** {{ $event->title }}
    - **Date:** {{ $event->formatted_event_date }}
    - **Location:** {{ $event->location }}
    - **Status:** {{ ucfirst($event->status) }}

    @if($event->registration_deadline)
        - **Registration Deadline:** {{ $event->formatted_registration_deadline }}
    @endif

    @if($event->max_participants)
        - **Max Participants:** {{ $event->max_participants }}
    @endif

    ## Description

    {{ $event->description }}

    <x-mail::button :url="route('events.show', $event)">
        View Event
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>