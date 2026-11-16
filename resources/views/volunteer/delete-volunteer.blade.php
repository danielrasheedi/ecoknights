@extends($layout)
@section('content')
    <h1>Delete volunteer</h1>
    
    @if (session('success'))
        <div>{{ session('success') }}</div>
    @endif
    
    @if (session('error'))
        <div>{{ session('error') }}</div>
    @endif

    @if(isset($participation))
        <p><strong>Are you sure you want to delete this volunteer participation?</strong></p>
        <p>This action cannot be undone.</p>
        
        <table border="1" style="margin: 20px 0;">
            <tbody>
                <tr>
                    <td><strong>Volunteer ID</strong></td>
                    <td>{{ $participation->VolunteerID }}</td>
                </tr>
                <tr>
                    <td><strong>Volunteer name</strong></td>
                    <td>{{ $participation->volunteer->UserFullName ?? $participation->volunteer->UserEmail ?? 'Unknown' }}</td>
                </tr>
                <tr>
                    <td><strong>Event name</strong></td>
                    <td>{{ $participation->event->EventName ?? 'Unknown Event' }}</td>
                </tr>
                <tr>
                    <td><strong>Event role</strong></td>
                    <td>{{ $participation->EventRole ?? 'Not assigned' }}</td>
                </tr>
                <tr>
                    <td><strong>Approval status</strong></td>
                    <td>{{ $participation->ApprovalStatus }}</td>
                </tr>
                <tr>
                    <td><strong>Attendance status</strong></td>
                    <td>{{ $participation->AttendanceStatus ?? 'Not recorded' }}</td>
                </tr>
                <tr>
                    <td><strong>Created at</strong></td>
                    <td>{{ $participation->CreatedAt ? $participation->CreatedAt->format('d M Y H:i') : 'Not available' }}</td>
                </tr>
            </tbody>
        </table>
        
        <div style="margin: 20px 0;">
            <form method="POST" action="{{ route('post-delete-volunteer', ['participationId' => $participation->ParticipationID]) }}" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure you want to delete this volunteer participation? This action cannot be undone.')">
                    Yes
                </button>
            </form>
            
            <a href="{{ route('get-read-volunteer') }}">
                <button type="button">No</button>
            </a>
        </div>
    @else
        <p>Participation record not found.</p>
        <a href="{{ route('get-read-volunteer') }}">
            <button type="button">Back to Volunteer Management</button>
        </a>
    @endif
@endsection