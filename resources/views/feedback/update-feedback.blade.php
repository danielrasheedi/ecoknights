@extends($layout)
@section('content')
    <h1>Update feedback</h1>
    
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

    @if(isset($feedback))
        <form method="POST" action="{{ route('post-update-feedback', $feedback->FeedbackID) }}">
            @csrf
            @method('PUT')
            
            <div>
                <label for="UserName">User name:</label>
                <input type="text" 
                       id="UserName" 
                       name="UserName" 
                       value="{{ $feedback->user->UserFullName ?? $feedback->user->UserEmail ?? 'Unknown' }}"
                       readonly>
            </div>
            
            <div>
                <label for="EventName">Event name:</label>
                <input type="text" 
                       id="EventName" 
                       name="EventName" 
                       value="{{ $feedback->event->EventName ?? 'Unknown Event' }}"
                       readonly>
            </div>
            
            <div>
                <label for="CreatedAt">Created at:</label>
                <input type="text" 
                       id="CreatedAt" 
                       name="CreatedAt" 
                       value="{{ $feedback->CreatedAt ? $feedback->CreatedAt->format('d M Y H:i') : 'Not available' }}"
                       readonly>
            </div>
            
            <div>
                <label for="EventRating">Event rating: *</label>
                <select id="EventRating" name="EventRating" required>
                    <option value="1" {{ old('EventRating', $feedback->EventRating ?? '') == '1' ? 'selected' : '' }}>1 - Very Poor</option>
                    <option value="2" {{ old('EventRating', $feedback->EventRating ?? '') == '2' ? 'selected' : '' }}>2 - Poor</option>
                    <option value="3" {{ old('EventRating', $feedback->EventRating ?? '') == '3' ? 'selected' : '' }}>3 - Average</option>
                    <option value="4" {{ old('EventRating', $feedback->EventRating ?? '') == '4' ? 'selected' : '' }}>4 - Good</option>
                    <option value="5" {{ old('EventRating', $feedback->EventRating ?? '') == '5' ? 'selected' : '' }}>5 - Excellent</option>
                </select>
            </div>
            
            <div>
                <label for="EventComment">Event comment: *</label>
                <textarea id="EventComment" 
                          name="EventComment" 
                          rows="3"
                          maxlength="1000"
                          required>{{ old('EventComment', $feedback->EventComment ?? '') }}</textarea>
            </div>
            
            <div>
                <button type="submit">Update</button>
                <button type="button" onclick="window.location.href='{{ route('get-read-feedback') }}'">Cancel</button>
            </div>
        </form>
        
        <p>* Required fields</p>
    @else
        <p>Feedback record not found.</p>
        <a href="{{ route('get-read-feedback') }}">
            <button type="button">Back to Feedback Management</button>
        </a>
    @endif
@endsection