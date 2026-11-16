@extends($layout)
@section('content')
    <h1>Volunteer</h1>
    
    <div style="margin-bottom: 20px;">
        <form method="GET" action="{{ route('get-read-volunteer') }}" class="search-form">
            <div>
                <input type="text" 
                       id="search_volunteer_id" 
                       name="search_volunteer_id" 
                       value="{{ request('search_volunteer_id') }}" 
                       placeholder="Enter volunteer ID">
            </div>
            <button type="submit" name="search" value="1">Search</button>
            <a href="{{ route('get-read-volunteer') }}">
                <button type="button">Clear</button>
            </a>
        </form>
    </div>
    
    @if($participations->count() > 0)
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Participation ID</th>
                        <th>Volunteer ID</th>
                        <th>Volunteer name</th>
                        <th>Event ID</th>
                        <th>Event name</th>
                        <th>Event role</th>
                        <th>Approval status</th>
                        <th>Attendance status</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($participations as $participation)
                        <tr>
                            <td data-label="Participation ID">{{ $participation->ParticipationID }}</td>
                            <td data-label="Volunteer ID">{{ $participation->VolunteerID }}</td>
                            <td data-label="Volunteer name">{{ $participation->volunteer->UserFullName ?? $participation->volunteer->UserEmail ?? 'Unknown' }}</td>
                            <td data-label="Event ID">{{ $participation->EventID }}</td>
                            <td data-label="Event name">{{ $participation->event->EventName ?? 'Unknown Event' }}</td>
                            <td data-label="Event role">{{ $participation->EventRole ?? 'Not assigned' }}</td>
                            <td data-label="Approval status">{{ $participation->ApprovalStatus }}</td>
                            <td data-label="Attendance status">{{ $participation->AttendanceStatus ?? 'Not recorded' }}</td>
                            <td data-label="Created at">{{ $participation->CreatedAt ? $participation->CreatedAt->format('d M Y H:i') : 'Not available' }}</td>
                            <td data-label="Updated at">{{ $participation->UpdatedAt ? $participation->UpdatedAt->format('d M Y H:i') : 'Not available' }}</td>
                            <td data-label="Actions">
                                <a href="{{ route('get-update-volunteer', ['participationId' => $participation->ParticipationID]) }}">
                                    <button type="button">Update</button>
                                </a>
                                <a href="{{ route('get-delete-volunteer', ['participationId' => $participation->ParticipationID]) }}">
                                    <button type="button">Delete</button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>No volunteer participations found.</p>
    @endif
@endsection