@extends($layout)
@section('content')
    <h1 class="hero-title">Taking Action<br>Towards<br>Sustainability,<br>That's What We Do</h1>
    
    <h2>Empowering people to live sustainably</h2>
    
    <h3>Our mission & vision</h3>
    <ul>
        <li>Environmental justice in Malaysia</li>
        <li>Building resilient youths</li>
        <li>Independent community in sustainable development</li>
        <li>Mainstreaming sustainability</li>
    </ul>
    
    <h2>Take a Stand and Lend a Hand!</h2>
    <p>Give your time to the environment to buy time for the environment! Come and join EcoKnights as a volunteer and save the environment in return! EcoKnights is consistently looking for interested people who are looking for some volunteering action from participating in clean-up activities, tree-planting or being part of a film festival. We need all hands on deck!</p>
    
    <hr>
    
    <h2>Completed Events</h2>
    
    @if($completedEvents->count() > 0)
        <div>
            @foreach($completedEvents as $event)
                <div class="event-card">
                    <h3>{{ $event->EventName }}</h3>

                    <div class="event-image">
                        @if(stripos($event->EventName, 'tree') !== false || stripos($event->EventName, 'plant') !== false)
                            <img src="{{ asset('images/tree-for-us.png') }}" alt="{{ $event->EventName }}">
                        @elseif(stripos($event->EventName, 'clean') !== false || stripos($event->EventName, 'garbage') !== false || stripos($event->EventName, 'waste') !== false)
                            <img src="{{ asset('images/guardians-against-garbage.jpeg') }}" alt="{{ $event->EventName }}">
                        @else
                            <span>Event Image</span>
                        @endif
                    </div>
                    
                    <p><strong>Description:</strong> {{ $event->EventDescription }}</p>
                    <p><strong>Start Date:</strong> {{ $event->EventStartDate ? $event->EventStartDate->format('d M Y') : 'TBA' }}</p>
                    <p><strong>End Date:</strong> {{ $event->EventEndDate ? $event->EventEndDate->format('d M Y') : 'TBA' }}</p>
                    <p><strong>Location:</strong> {{ $event->EventLocation ?? 'TBA' }}</p>
                </div>
            @endforeach
        </div>
    @else
        <p>No completed events found.</p>
    @endif
@endsection