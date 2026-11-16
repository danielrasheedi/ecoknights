@extends($layout)
@section('content')
    <h1>Upcoming Volunteer Events</h1>
    
    @if (session('success'))
        <div>{{ session('success') }}</div>
    @endif
    
    @if (session('error'))
        <div>{{ session('error') }}</div>
    @endif
    
    @if($upcomingEvents->count() > 0)
        <div>
            @foreach($upcomingEvents as $event)
                @php
                    $isClosed = $event->MaxVolunteers && $event->approved_count >= $event->MaxVolunteers;
                    $userRole = session('user_role');
                @endphp
                
                <div class="event-card">
                    <h3>{{ $event->EventName }}</h3>
                    <p><strong>Description:</strong> {{ $event->EventDescription }}</p>
                    <p><strong>Start date:</strong> {{ $event->EventStartDate ? $event->EventStartDate->format('d M Y') : 'TBA' }}</p>
                    <p><strong>End date:</strong> {{ $event->EventEndDate ? $event->EventEndDate->format('d M Y') : 'TBA' }}</p>
                    <p><strong>Location:</strong> {{ $event->EventLocation ?? 'TBA' }}</p>
                    <p><strong>Max volunteers:</strong> {{ $event->MaxVolunteers ?? 'Unlimited' }}</p>
                    
                    @if($event->coordinator)
                        <p><strong>Coordinator:</strong> {{ $event->coordinator->UserFullName ?? $event->coordinator->UserEmail }}</p>
                    @endif
                    
                    @if($isClosed)
                        <p>Registration is closed for this event.</p>
                    @elseif($userRole === 'Event Coordinator')
                        <p>Event coordinators are assigned to events by administrators.</p>
                    @else
                        <form method="POST" action="{{ route('post-create-volunteer', $event->EventID) }}" style="margin-top: 10px;">
                            @csrf
                            <button type="submit">Sign up</button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <p>No upcoming events available at the moment.</p>
    @endif
@endsection