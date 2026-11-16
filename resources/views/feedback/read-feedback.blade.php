@extends($layout)
@section('content')
    <h1>Feedback</h1>

    <div style="margin-bottom: 20px;">
        <form method="GET" action="{{ route('get-read-feedback') }}" class="search-form">
            <div>
                <input type="text" 
                       id="search_user_id" 
                       name="search_user_id" 
                       value="{{ request('search_user_id') }}" 
                       placeholder="Enter user ID">
            </div>
            <button type="submit" name="search" value="1">Search</button>
            <a href="{{ route('get-read-feedback') }}">
                <button type="button">Clear</button>
            </a>
        </form>
    </div>
    
    @if($feedbacks->count() > 0)
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Feedback ID</th>
                        <th>User ID</th>
                        <th>User name</th>
                        <th>Event ID</th>
                        <th>Event name</th>
                        <th>Event rating</th>
                        <th>Event comment</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($feedbacks as $feedback)
                        <tr>
                            <td data-label="Feedback ID">{{ $feedback->FeedbackID }}</td>
                            <td data-label="User ID">{{ $feedback->UserID }}</td>
                            <td data-label="User name">{{ $feedback->user->UserFullName ?? $feedback->user->UserEmail ?? 'Unknown' }}</td>
                            <td data-label="Event ID">{{ $feedback->EventID }}</td>
                            <td data-label="Event name">{{ $feedback->event->EventName ?? 'Unknown Event' }}</td>
                            <td data-label="Event rating">{{ $feedback->EventRating }}/5</td>
                            <td data-label="Event comment">{{ $feedback->EventComment ?? 'No comment' }}</td>
                            <td data-label="Created at">{{ $feedback->CreatedAt ? $feedback->CreatedAt->format('d M Y H:i') : 'Not available' }}</td>
                            <td data-label="Updated at">{{ $feedback->UpdatedAt ? $feedback->UpdatedAt->format('d M Y H:i') : 'Not available' }}</td>
                            <td data-label="Actions">
                                <a href="{{ route('get-update-feedback', ['feedbackId' => $feedback->FeedbackID]) }}">
                                    <button type="button">Update</button>
                                </a>
                                <a href="{{ route('get-delete-feedback', ['feedbackId' => $feedback->FeedbackID]) }}">
                                    <button type="button">Delete</button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>No feedback records found.</p>
    @endif
@endsection