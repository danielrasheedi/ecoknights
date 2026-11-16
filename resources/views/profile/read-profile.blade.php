@extends($layout)
@section('content')
    <h1>Profile</h1>
    
    @php
        $userRole = session('user_role');
    @endphp
    
    @if($userRole === 'Administrator' && isset($users))  
        <div style="margin-bottom: 20px;">
            <form method="GET" action="{{ route('get-read-profile') }}" class="search-form">
                <div>
                    <input type="text" 
                           id="search_user_id" 
                           name="search_user_id" 
                           value="{{ request('search_user_id') }}" 
                           placeholder="Enter user ID">
                </div>
                <button type="submit" name="search" value="1">Search</button>
                <a href="{{ route('get-read-profile') }}">
                    <button type="button">Clear</button>
                </a>
            </form>
        </div>

        <div style="margin-bottom: 20px;">
            <a href="{{ route('get-create-profile') }}">+ Create new user</a>
        </div>
        
        @if($users->count() > 0)
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Full name</th>
                            <th>Date of birth</th>
                            <th>Gender</th>
                            <th>Email</th>
                            <th>Phone number</th>
                            <th>Address</th>
                            <th>Occupation</th>
                            <th>Transportation</th>
                            <th>Shirt size</th>
                            <th>Dietary requirements</th>
                            <th>Medical conditions</th>
                            <th>Skills and experiences</th>
                            <th>Role</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td data-label="User ID">{{ $user->UserID }}</td>
                                <td data-label="Full name">{{ $user->UserFullName ?? 'Not provided' }}</td>
                                <td data-label="Date of birth">{{ $user->UserDateOfBirth ? $user->UserDateOfBirth->format('d M Y') : 'Not provided' }}</td>
                                <td data-label="Gender">{{ $user->UserGender ?? 'Not provided' }}</td>
                                <td data-label="Email">{{ $user->UserEmail ?? 'Not provided' }}</td>
                                <td data-label="Phone number">{{ $user->UserPhoneNumber ?? 'Not provided' }}</td>
                                <td data-label="Address">{{ $user->UserAddress ?? 'Not provided' }}</td>
                                <td data-label="Occupation">{{ $user->UserOccupation ?? 'Not provided' }}</td>
                                <td data-label="Transportation">{{ $user->UserTransport ?? 'Not provided' }}</td>
                                <td data-label="Shirt size">{{ $user->UserShirtSize ?? 'Not provided' }}</td>
                                <td data-label="Dietary requirements">{{ $user->UserDietaryRequirements ?? 'Not provided' }}</td>
                                <td data-label="Medical conditions">{{ $user->UserMedicalConditions ?? 'Not provided' }}</td>
                                <td data-label="Skills and experiences">{{ $user->UserSkillsAndExperiences ?? 'Not provided' }}</td>
                                <td data-label="Role">{{ $user->UserRole ?? 'Not provided' }}</td>
                                <td data-label="Created at">{{ $user->CreatedAt ? $user->CreatedAt->format('d M Y H:i') : 'Not available' }}</td>
                                <td data-label="Updated at">{{ $user->UpdatedAt ? $user->UpdatedAt->format('d M Y H:i') : 'Not available' }}</td>
                                <td data-label="Actions">
                                    <a href="{{ route('get-administrator-update-profile', ['id' => $user->UserID]) }}">
                                        <button type="button">Update</button>
                                    </a>
                                    <a href="{{ route('get-delete-profile', ['id' => $user->UserID]) }}">
                                        <button type="button">Delete</button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>No users found.</p>
        @endif
    @endif
@endsection