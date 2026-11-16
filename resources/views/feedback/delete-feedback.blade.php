@extends($layout)
@section('content')
    <h1>Delete feedback</h1>
    
    @if (session('success'))
        <div>{{ session('success') }}</div>
    @endif
    
    @if (session('error'))
        <div>{{ session('error') }}</div>
    @endif

    @if(isset($feedback))
        <p><strong>Are you sure you want to delete this feedback?</strong></p>
        <p>This action cannot be undone.</p>
        
        <table border="1" style="margin: 20px 0;">
            <tbody>
                <tr>
                    <td><strong>User ID</strong></td>
                    <td>{{ $feedback->UserID }}</td>
                </tr>
                <tr>
                    <td><strong>User name</strong></td>
                    <td>{{ $feedback->user->UserFullName ?? $feedback->user->UserEmail ?? 'Unknown' }}</td>
                </tr>
                <tr>
                    <td><strong>Event name</strong></td>
                    <td>{{ $feedback->event->EventName ?? 'Unknown Event' }}</td>
                </tr>
                <tr>
                    <td><strong>Event rating</strong></td>
                    <td>{{ $feedback->EventRating }}/5</td>
                </tr>
                <tr>
                    <td><strong>Event comment</strong></td>
                    <td>{{ $feedback->EventComment ?? 'No comment' }}</td>
                </tr>
                <tr>
                    <td><strong>Created at</strong></td>
                    <td>{{ $feedback->CreatedAt ? $feedback->CreatedAt->format('d M Y H:i') : 'Not available' }}</td>
                </tr>
            </tbody>
        </table>
        
        <div style="margin: 20px 0;">
            <form method="POST" action="{{ route('post-delete-feedback', ['feedbackId' => $feedback->FeedbackID]) }}" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure you want to delete this feedback? This action cannot be undone.')">
                    Yes
                </button>
            </form>
            
            <a href="{{ route('get-read-feedback') }}">
                <button type="button">No</button>
            </a>
        </div>
    @else
        <p>Feedback record not found.</p>
        <a href="{{ route('get-read-feedback') }}">
            <button type="button">Back to Feedback Management</button>
        </a>
    @endif
@endsection