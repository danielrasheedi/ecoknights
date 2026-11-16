@extends($layout)
@section('content')
    <h1>Feedback</h1>
    
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

    @if($completedEvents->count() > 0)
        <form method="POST" action="{{ route('post-create-feedback') }}">
            @csrf
            
            <div>
                <label for="EventID">Event: *</label>
                <select id="EventID" name="EventID" required>
                    <option value=""></option>
                    @foreach($completedEvents as $event)
                        <option value="{{ $event->EventID }}" {{ old('EventID') == $event->EventID ? 'selected' : '' }}>
                            {{ $event->EventName }} - {{ $event->EventStartDate ? $event->EventStartDate->format('d M Y') : 'TBA' }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label for="EventRating">Rating: *</label>
                <select id="EventRating" name="EventRating" required>
                    <option value=""></option>
                    <option value="1" {{ old('EventRating') == '1' ? 'selected' : '' }}>1 - Very Poor</option>
                    <option value="2" {{ old('EventRating') == '2' ? 'selected' : '' }}>2 - Poor</option>
                    <option value="3" {{ old('EventRating') == '3' ? 'selected' : '' }}>3 - Average</option>
                    <option value="4" {{ old('EventRating') == '4' ? 'selected' : '' }}>4 - Good</option>
                    <option value="5" {{ old('EventRating') == '5' ? 'selected' : '' }}>5 - Excellent</option>
                </select>
            </div>
            
            <div>
                <label for="EventComments">Comments: *</label>
                <textarea id="EventComments" 
                          name="EventComments" 
                          rows="3"
                          required>{{ old('EventComments') }}</textarea>
            </div>
            
            <div>
                <button type="submit">Submit</button>
            </div>
        </form>
        
        <p>* Required fields</p>
    @else
        <p>You have not participated in any completed events yet. Feedback can only be provided for events you have attended.</p>
    @endif
@endsection