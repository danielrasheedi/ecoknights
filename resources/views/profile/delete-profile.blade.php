@extends($layout)
@section('content')
    <h1>Delete profile</h1>
    
    @if (session('success'))
        <div>{{ session('success') }}</div>
    @endif
    
    @if (session('error'))
        <div>{{ session('error') }}</div>
    @endif

    @if(isset($user))
        <p><strong>Are you sure you want to delete this profile?</strong></p>
        <p>This action cannot be undone.</p>
        
        <table border="1" style="margin: 20px 0;">
            <tbody>
                <tr>
                    <td><strong>User ID</strong></td>
                    <td>{{ $user->UserID }}</td>
                </tr>
                <tr>
                    <td><strong>Full name</strong></td>
                    <td>{{ $user->UserFullName ?? 'Not provided' }}</td>
                </tr>
                <tr>
                    <td><strong>Email</strong></td>
                    <td>{{ $user->UserEmail ?? 'Not provided' }}</td>
                </tr>
                <tr>
                    <td><strong>Role</strong></td>
                    <td>{{ $user->UserRole ?? 'Not provided' }}</td>
                </tr>
                <tr>
                    <td><strong>Created at</strong></td>
                    <td>{{ $user->CreatedAt ? $user->CreatedAt->format('d M Y H:i') : 'Not available' }}</td>
                </tr>
            </tbody>
        </table>
        
        <div style="margin: 20px 0;">
            <form method="POST" action="{{ route('post-delete-profile', ['id' => $user->UserID]) }}" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure you want to delete this profile? This action cannot be undone.')">
                    Yes
                </button>
            </form>
            
            <a href="{{ route('get-read-profile') }}">
                <button type="button">No</button>
            </a>
        </div>
    @else
        <p>User not found.</p>
        <a href="{{ route('get-read-profile') }}">
            <button type="button">Back to Profiles</button>
        </a>
    @endif
@endsection