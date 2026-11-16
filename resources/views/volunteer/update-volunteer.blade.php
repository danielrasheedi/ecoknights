@extends($layout)
@section('content')
    <h1>Update volunteer</h1>
    
    @if (session('success'))
        <div>{{ session('success') }}</div>
    @endif
    
    @if (session('error'))
        <div>{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(isset($participation))
        <form method="POST" action="{{ route('post-update-volunteer', $participation->ParticipationID) }}">
            @csrf
            @method('PUT')
            
            <div>
                <label for="VolunteerName">Volunteer name:</label>
                <input type="text" 
                       id="VolunteerName" 
                       name="VolunteerName" 
                       value="{{ $participation->volunteer->UserFullName ?? $participation->volunteer->UserEmail ?? 'Unknown' }}"
                       readonly>
            </div>
            
            <div>
                <label for="EventName">Event name:</label>
                <input type="text" 
                       id="EventName" 
                       name="EventName" 
                       value="{{ $participation->event->EventName ?? 'Unknown Event' }}"
                       readonly>
            </div>
            
            <div>
                <label for="AppliedAt">Created at:</label>
                <input type="text" 
                       id="AppliedAt" 
                       name="AppliedAt" 
                       value="{{ $participation->CreatedAt ? $participation->CreatedAt->format('d M Y H:i') : 'Not available' }}"
                       readonly>
            </div>
            
            <div>
                <label for="EventRole">Event role:</label>
                <input type="text" 
                       id="EventRole" 
                       name="EventRole" 
                       value="{{ old('EventRole', $participation->EventRole ?? '') }}"
                       maxlength="100"
                       placeholder="e.g., Registration Assistant, Setup Crew">
            </div>
            
            <div>
                <label for="ApprovalStatus">Approval status:</label>
                <select id="ApprovalStatus" name="ApprovalStatus">
                    <option value="Pending" {{ old('ApprovalStatus', $participation->ApprovalStatus ?? '') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Approved" {{ old('ApprovalStatus', $participation->ApprovalStatus ?? '') == 'Approved' ? 'selected' : '' }}>Approved</option>
                    <option value="Rejected" {{ old('ApprovalStatus', $participation->ApprovalStatus ?? '') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            
            <div>
                <label for="AttendanceStatus">Attendance status:</label>
                <select id="AttendanceStatus" name="AttendanceStatus">
                    <option value="">Not recorded</option>
                    <option value="Attended" {{ old('AttendanceStatus', $participation->AttendanceStatus ?? '') == 'Attended' ? 'selected' : '' }}>Attended</option>
                    <option value="Absent" {{ old('AttendanceStatus', $participation->AttendanceStatus ?? '') == 'Absent' ? 'selected' : '' }}>Absent</option>
                </select>
            </div>
            
            <div>
                <button type="submit">Update</button>
                <button type="button" onclick="window.location.href='{{ route('get-read-volunteer') }}'">Cancel</button>
            </div>
        </form>
        
    @else
        <p>Participation record not found.</p>
        <a href="{{ route('get-read-volunteer') }}">
            <button type="button">Back to Volunteer Management</button>
        </a>
    @endif
@endsection